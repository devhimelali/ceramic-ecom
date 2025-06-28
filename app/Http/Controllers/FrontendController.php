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
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class FrontendController extends Controller
{
    public function home()
    {
        $data = [
            'setting' => Setting::get(),
            'active' => 'home',
            'sliders' => Slider::get(),
            'products' => Product::with(['images', 'reviews' => function ($q) {
                return $q->where('is_approved', 1);
            }])->where('status', StatusEnum::ACTIVE)->latest()->limit(12)->get(),


            'featuredCategories' => Category::where('is_featured', 1)->get(),
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
        $query = Product::with(['images', 'variations.images', 'reviews' => function ($q) {
            return $q->where('is_approved', 1);
        }])->where('status', StatusEnum::ACTIVE);
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
        $reviews = Review::with(['images', 'videos']) // Ensure videos are eager loaded
            ->where('is_approved', 1)
            ->where('product_id', $request->product_id)
            ->latest();

        if (!empty($request->rating)) {
            $reviews = $reviews->where('rating', $request->rating);
        }

        if (!empty($request->with_media)) {
            $reviews = $reviews->where(function ($q) {
                $q->whereHas('images')->orWhereHas('videos');
            });
        }

        return DataTables::of($reviews)
            ->addColumn('review_details', function ($review) {
                $stars = '';
                for ($i = 1; $i <= 5; $i++) {
                    $stars .= '<i class="' . ($i <= $review->rating ? 'fas' : 'far') . ' fa-star text-warning" style="font-size: 14px;"></i>';
                }

                return '
                <div class="d-flex align-items-center gap-2">
                    <div style="min-width: 100px">' . $stars . '</div>
                    <p class="mb-0" style="min-width: 250px; line-height: normal;">' . e($review->headline) . '</p>
                </div>
                <p class="mb-0" style="font-size: 12px; line-height: normal;">' . e($review->comment) . '</p>';
            })
            ->filterColumn('review_details', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('headline', 'like', "%$keyword%")
                        ->orWhere('comment', 'like', "%$keyword%");
                });
            })
            ->addColumn('name', function ($review) {
                $avatar = asset('frontend/assets/images/user-avatar-with-check-mark.png');
                $date = $review->created_at->format('d/m/Y');
                return '
                <div class="d-flex align-items-center" style="min-width: 200px;">
                    <img src="' . $avatar . '" alt="' . e($review->name) . '" class="rounded-circle" width="30" height="30">
                    <div>
                        <span class="ms-2">' . e($review->name) . '</span>
                        <div class="text-success ms-2" style="font-size: 12px;">Verified Buyer</div>
                        <span class="text-muted ms-2" style="font-size: 12px;">' . $date . '</span>
                    </div>
                </div>
                ';
            })
            ->editColumn('media', function ($review) {
                $galleryId = 'gallery-' . $review->id;
                $output = '<div id="' . $galleryId . '" class="gallery-container" style="min-width: 300px;">';
                $images = $review->images->where('image_type', 'review-image');
                foreach ($images as $image) {
                    $url = asset($image->path);
                    $output .= '<a href="' . $url . '" class="lg-thumb">';
                    $output .= '<img src="' . $url . '" class="img-fluid">';
                    $output .= '</a>';
                }
                $output .= '</div>';
                return $output;
            })
            ->addColumn('video', function ($review) {
                $output = '<div id="video-gallery-' . $review->id . '" class="video-gallery-container d-flex gap-2 flex-wrap" style="min-width: 300px;">';
                $thumbnails = $review->images->where('image_type', 'video-thumbnail')->values();

                foreach ($review->videos as $key => $video) {
                    $thumbPath = isset($thumbnails[$key]) ? asset('storage/' . $thumbnails[$key]->path) : null;
                    $videoPath = asset($video->url); // local mp4 or external video URL

                    $output .= '<a href="' . $videoPath . '" class="glightbox" data-type="video" data-gallery="review-videos-' . $review->id . '" style="position: relative; display: inline-block;">';

                    if ($thumbPath) {
                        $output .= '<img src="' . $thumbPath . '" style="width: 100px; height: 60px; border-radius: 6px;">';
                        $output .= '<span class="position-absolute top-50 start-50 translate-middle" style="pointer-events: none;">
                            <i class="bi bi-play-circle-fill text-white" style="font-size: 2rem;"></i>
                        </span>';
                    } else {
                        $output .= '<div class="bg-dark d-flex align-items-center justify-content-center" style="width: 100px; height: 60px;">
                            <i class="bi bi-play-circle-fill text-white" style="font-size: 2rem;"></i>
                        </div>';
                    }

                    $output .= '</a>';
                }

                $output .= '</div>';
                return $output;
            })
            ->rawColumns(['review_details', 'media', 'name', 'video'])
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
                if ($image instanceof \Illuminate\Http\UploadedFile && $image->isValid()) {
                    $fileInfo = uploadImage($image, 'products/reviews/images');
                    $review->images()->create([
                        'name' => $fileInfo['name'],
                        'path' => $fileInfo['path'],
                        'image_type' => 'review-image'
                    ]);
                } else {
                    // \Log::error('Invalid file detected', ['file' => $image]);
                }
            }
        }

        if ($request->has('video_thumbnails')) {
            foreach ($request->video_thumbnails as $index => $base64) {
                $data = explode(',', $base64);
                $imageData = base64_decode($data[1]);
                $imageName = 'thumb_' . time() . '_' . $index . '.jpg';
                Storage::disk('public')->put('video-thumbnails/' . $imageName, $imageData);

                $review->images()->create([
                    'name' => $imageName,
                    'path' => 'video-thumbnails/' . $imageName,
                    'image_type' => 'video-thumbnail'
                ]);
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                if ($video instanceof \Illuminate\Http\UploadedFile && $video->isValid()) {
                    $fileInfo = uploadVideo($video, 'products/reviews/videos');
                    $review->videos()->create([
                        'title' => $fileInfo['name'],
                        'url' => $fileInfo['path'],
                    ]);
                } else {
                    // \Log::error('Invalid file detected', ['file' => $video]);
                }
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
