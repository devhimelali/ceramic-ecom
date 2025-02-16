<?php

namespace App\Http\Controllers;

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
            'products' => Product::with('images', 'attributes', 'attributeValues')->where('status', StatusEnum::ACTIVE)->latest()->limit(4)->get(),
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
        $query = Product::query();
        // if ($request->has('attribute')) {
        //     $decryptedValues = array_map(function ($value) {
        //         return base64_decode($value, true);
        //     }, explode(',', $request->input('attribute')));
        //     $attributes = $decryptedValues;
        //     $query->whereHas('attributes', function ($query) use ($attributes) {
        //         $query->whereIn('product_attribute_values.attribute_value_id', $attributes);
        //     });
        // }


        if ($request->has('attribute')) {
            $decryptedValues = array_filter(array_map(function ($value) {
                $decoded = base64_decode($value, true);
                return $decoded !== false ? $decoded : null;
            }, explode(',', $request->input('attribute'))));
            // dd($decryptedValues);
            if (!empty($decryptedValues)) {
                $attributes = $decryptedValues;
                // dd($attributes);
                foreach ($attributes as $key => $value) {
                    // dd($value);
                    $query->whereHas('attributes', function ($query) use ($value) {
                        $query->where('product_attribute_values.attribute_value_id', $value);
                    });
                }
            }
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
        $attributesData = Attribute::with([
            'values' => function ($query) {
                $query->where('status', StatusEnum::ACTIVE)
                    ->whereNotNull('value');
            }
        ])->get();
        return view('frontend.products.index', [
            'active'     => 'products',
            'attributes' => $attributesData,
            'brands' => Brand::where('status', StatusEnum::ACTIVE)->latest()->get(),
        ]);
    }

    function decryptAttributeValues($encryptedValues)
    {
        return array_map('base64_decode', explode(',', $encryptedValues));
    }

    function productDetails($slug)
    {
        $product = Product::with('attributes', 'attributeValues')->where('slug', $slug)->first();

        $result = [];

        // Iterate over the product's attributes
        foreach ($product->attributes as $attribute) {
            // Get the attribute name
            $attributeName = $attribute->name;

            // Get the value from the pivot table
            $pivotValueId = $attribute->pivot->attribute_value_id; // This will now be available

            // Find the corresponding value from the attribute values
            $selectedValue = $attribute->values->firstWhere('id', $pivotValueId);

            if ($selectedValue) {
                if (!isset($result[$attributeName])) {
                    $result[$attributeName] = [
                        'attribute' => $attributeName,
                        'values' => [],
                    ];
                }

                // Append the value if not already added
                if (!in_array($selectedValue->value, $result[$attributeName]['values'])) {
                    $result[$attributeName]['values'][] = $selectedValue->value;
                }
            }
        }
        $data = [
            'active' => 'products',
            'product' => $product,
            'attributes' => $result
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
}
