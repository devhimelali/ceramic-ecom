<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Setting;
use App\Enum\StatusEnum;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $data = [
            'setting' => Setting::get(),
            'active' => 'home',
            'sliders' => Slider::get(),
            'brands' => Brand::where('status', StatusEnum::ACTIVE)->latest()->limit(15)->get(),
            'products' => Product::with('images', 'variations.images')->where('status', StatusEnum::ACTIVE)->latest()->limit(4)->get()
        ];

        return view('frontend.home', $data);
    }


    public function allCategories()
    {
        $categories = Category::where('is_active', 1)->paginate(10);

        return view('frontend.categories', [
            'active' => 'allCategories',
            'categories' => $categories
        ]);
    }

    public function productsPage(Request $request)
    {
        $attributes = [];
        $query = Product::with('images', 'variations.images')->where('status', StatusEnum::ACTIVE);


        if ($request->has('attribute')) {
            $decryptedValues = array_filter(array_map(function ($value) {
                $decoded = base64_decode($value, true);
                return $decoded !== false ? $decoded : null;
            }, explode(',', $request->input('attribute'))));
            if (!empty($decryptedValues)) {
                $attributes = $decryptedValues;

                $query->whereHas('variations', function ($q) use ($attributes) {
                    foreach ($attributes as $index => $value) {
                        if ($index === 0) {
                            $q->where('attribute_string', 'like', '%' . $value . '%');
                        } else {
                            $q->orWhere('attribute_string', 'like', '%' . $value . '%');
                        }
                    }
                });
            }
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
            $query->where('category_id', $request->category);
        }
        if ($request->has('brand')) {
            $query->where('brand_id', $request->brand);
        }
        $products = $query->paginate(12);
        if ($request->ajax()) {
            // sleep(1);
            $html = view('frontend.products.product_list', compact('products'))->render();
            $pagination = $products->links('pagination::bootstrap-4')->toHtml();
            return response()->json([
                'status' => 'success',
                'html'   => $html,
                'pagination' => $pagination,
                'result' => [],
                'message' => 'Products updated successfully!',
            ]);
        }

        $allAttributes = Attribute::with('values')->get();

        $groupedAttributes = $allAttributes->groupBy('name')->map(function ($attributes) {
            // Merge all values across attributes with same name and remove duplicates
            return $attributes->flatMap->values->unique('value');
        });

        return view('frontend.products.index', [
            'active'     => 'products',
            'attributes' => $groupedAttributes,
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

        $data = [
            'active' => 'products',
            'product' => $product,
            'attributes' => $attributes
        ];
        return view('frontend.products.details', $data);
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
}
