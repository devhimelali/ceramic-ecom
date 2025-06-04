<?php

namespace App\Http\Controllers;

use App\Enum\ProductLabelEnum;
use App\Http\Requests\Frontend\ReviewRequest;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Setting;
use App\Enum\StatusEnum;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FrontendController extends Controller
{
    public function home()
    {
        $data = [
            'setting' => Setting::get(),
            'active' => 'home',
            'sliders' => Slider::get(),
            // 'brands' => Brand::where('status', StatusEnum::ACTIVE)->latest()->limit(15)->get(),
            'products' => Product::with('images', 'variations.images')->where('status', StatusEnum::ACTIVE)->latest()->limit(12)->get(),
            'topSellingProducts' => Product::with('images', 'variations.images')->where('status', StatusEnum::ACTIVE)->where('label', ProductLabelEnum::TOP_SELLING)->latest()->limit(12)->get(),
            'featuredProducts' => Product::with('images', 'variations.images')->where('status', StatusEnum::ACTIVE)->where('label', ProductLabelEnum::FEATURED)->latest()->limit(12)->get(),
        ];

        return view('frontend.home', $data);
    }


    public function allCategories()
    {
        $categories = Category::where('is_active', 1)->where('parent_id', null)->paginate(12);

        return view('frontend.categories', [
            'active' => 'allCategories',
            'categories' => $categories
        ]);
    }

    public function productsPage(Request $request)
    {
        $attributes = [];
        $query = Product::with('images', 'variations.images')->where('status', StatusEnum::ACTIVE);
        if (!empty($request->sort_by)) {
            if ($request->sort_by == 'low-to-high') {
                $query = $query->orderByRaw('COALESCE(sale_price, regular_price) ASC');
            } else if ($request->sort_by == 'high-to-low') {
                $query = $query->orderByRaw('COALESCE(sale_price, regular_price) DESC');
            }
        } else {
            $query = $query->latest();
        }


        if ($request->has('attribute')) {
            // dd($request->input('attribute')); // Check the input
            $attributes = $request->input('attribute'); // Get the full attribute data

            // Loop through each attribute type (e.g., "Size", "Color")
            $query->whereHas('variations', function ($q) use ($attributes) {
                foreach ($attributes as $attributeName => $values) {
                    foreach ($values as $index => $value) {
                        if ($index === 0) {
                            $q->where('attribute_string', 'like', '%' . $value . '%');
                        } else {
                            $q->orWhere('attribute_string', 'like', '%' . $value . '%');
                        }
                    }
                }
            });
        }


        if ($request->has('min_price') && $request->has('max_price')) {
            $min = $request->min_price;
            $max = $request->max_price;

            $query->whereRaw('COALESCE(sale_price, regular_price) BETWEEN ? AND ?', [$min, $max]);
        }


        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();

            if ($category) {
                // Get the selected category and its subcategory IDs
                $categoryIds = Category::where('parent_id', $category->id)
                    ->pluck('id')
                    ->push($category->id); // Include the selected category ID

                $query->whereIn('category_id', $categoryIds);
            }
        }
        if ($request->has('brand')) {
            $query->where('brand_id', $request->brand);
        }
        $products = $query->paginate(12);
        // if ($request->ajax()) {
        //     // sleep(1);
        //     $html = view('frontend.products.product_list', compact('products'))->render();
        //     $pagination = $products->links('pagination::bootstrap-4')->toHtml();
        //     return response()->json([
        //         'status' => 'success',
        //         'html'   => $html,
        //         'pagination' => $pagination,
        //         'result' => [],
        //         'message' => 'Products updated successfully!',
        //     ]);
        // }

        $allAttributes = Attribute::with('values')->get();

        $groupedAttributes = $allAttributes->groupBy('name')->map(function ($attributes) {
            // Merge all values across attributes with same name and remove duplicates
            return $attributes->flatMap->values->unique('value');
        });

        return view('frontend.products.index', [
            'active' => 'products',
            'attributes' => $groupedAttributes,
            'products' => $products,
            'brands' => Brand::where('status', StatusEnum::ACTIVE)->latest()->get(),
        ]);
    }

    function decryptAttributeValues($encryptedValues)
    {
        return array_map('base64_decode', explode(',', $encryptedValues));
    }

    function productDetails($slug)
    {
        $product = Product::with('images', 'attributes', 'variations.images')->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::with('images', 'attributes', 'variations.images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        $attributes = Attribute::with('values')
            ->where('product_id', $product->id)
            ->get()
            ->groupBy('name')
            ->map(function ($group, $name) {
                return [
                    'attribute' => $name,
                    'values' => $group->flatMap->values->pluck('value')->unique()->values(),
                ];
            })->values();

        $reviews = $product->reviews()->where('is_approved', 1)->latest()->paginate(10);
        $avgRating = $product->reviews()->where('is_approved', 1)->avg('rating');
        $totalRating = $product->reviews()->where('is_approved', 1)->count();
        $isReviewExists = $product->reviews()->where('is_approved', 1)->exists();

        $data = [
            'active' => 'products',
            'product' => $product,
            'attributes' => $attributes,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'avgRating' => $avgRating,
            'totalRating' => $totalRating,
            'product_id' => $product->id,
            'isReviewExists' => $isReviewExists
        ];
        return view('frontend.products.details', $data);
    }

    public function getReviewsData(Request $request)
    {
        $reviews = Review::with('images')
            ->where('is_approved', 1)
            ->where('product_id', $request->product_id)
            ->latest();

        return DataTables::of($reviews)
            ->addColumn('review_details', function ($review) {
                $stars = '';
                for ($i = 1; $i <= 5; $i++) {
                    $stars .= '<i class="' . ($i <= $review->rating ? 'fas' : 'far') . ' fa-star text-warning" style="font-size: 12px;"></i>';
                }

                return '
                <div class="d-flex align-items-center gap-2">
                    <div>' . $stars . '</div>
                    <p class="mb-0 fw-bold">' . e($review->headline) . '</p>
                </div>
                <p class="mb-0" style="font-size: 12px;">' . e($review->comment) . '</p>';
            })
            ->filterColumn('review_details', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('headline', 'like', "%$keyword%")
                        ->orWhere('comment', 'like', "%$keyword%");
                });
            })
            ->editColumn('media', function ($review) {
                $galleryId = 'gallery-' . $review->id;
                $output = '<div id="' . $galleryId . '" class="gallery-container d-flex">';
                foreach ($review->images as $image) {
                    $url = asset($image->path);
                    $output .= '<a href="' . $url . '" class="lg-thumb">';
                    $output .= '<img src="' . $url . '" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; margin-right: 5px;">';
                    $output .= '</a>';
                }
                $output .= '</div>';
                return $output;
            })
            ->rawColumns(['review_details', 'media'])
            ->make(true);
    }


    public function storeProductReview(ReviewRequest $request)
    {
        $product = Product::find($request->product_id);

        $review = $product->reviews()->create([
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'headline' => $request->headline
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileInfo = uploadImage($image, 'products/reviews/images');
                $review->images()->create([
                    'name' => $fileInfo['name'],
                    'path' => $fileInfo['path'],
                ]);
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $fileInfo = uploadVideo($video, 'products/reviews/videos');
                $review->videos()->create([
                    'title' => $fileInfo['name'],
                    'url' => $fileInfo['path'],
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Review submitted successfully. Please wait for admin approval.',
        ]);
    }

    function aboutUs()
    {
        $data = [
            'active' => 'about-us'
        ];
        return view('frontend.about-us', $data);
    }

    public function termAndCondition()
    {
        $data = [
            'active' => 'terms-and-conditions'
        ];
        return view('frontend.terms_and_conditions', $data);
    }

    public function privacyPolicy()
    {
        $data = [
            'active' => 'privacy-policy'
        ];
        return view('frontend.privacy_policy', $data);
    }

    public function returnPolicy()
    {
        $data = [
            'active' => 'return-policy'
        ];
        return view('frontend.return_policy', $data);
    }
}
