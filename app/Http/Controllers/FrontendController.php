<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Enum\StatusEnum;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $data = [
            'active' => 'home',
            'brands' => Brand::where('status', StatusEnum::ACTIVE)->latest()->limit(15)->get(),
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

        if ($request->has('attribute')) {
            foreach ($request->attribute as $attributeId => $encryptedValues) {
                $attributes[$attributeId] = $this->decryptAttributeValues($encryptedValues);
            }
        }
        // dd($attributes);
        if ($request->ajax()) {
            // sleep(3);
            $html = view('frontend.products.product_list')->render();

            return response()->json([
                'status' => 'success',
                'html'   => $html,
                'message' => 'Products updated successfully!',
            ]);
        }
        // dd($request->all());
        $data = [
            'active' => 'products',
            'attributes' => Attribute::with(['values' => function ($query) {
                $query->where('status', StatusEnum::ACTIVE)
                    ->whereNotNull('value');
            }])->get(),
        ];

        return view('frontend.products.index', $data);
    }

    public function products(Request $request)
    {
        $attributes = [];

        if ($request->has('attribute')) {
            foreach ($request->attribute as $attributeId => $encryptedValues) {
                $attributes[$attributeId] = $this->decryptAttributeValues($encryptedValues);
            }
        }

        // Fetch products based on filters from the request
        $products = Category::query();

        // if ($request->has('category')) {
        //     $products->where('category_id', $request->category);
        // }

        // if ($request->has('color')) {
        //     $products->where('color', $request->color);
        // }

        // if ($request->has('price_min') && $request->has('price_max')) {
        //     $products->whereBetween('price', [$request->price_min, $request->price_max]);
        // }

        $products = $products->get();

        $html = view('frontend.products.product_list', compact('products'))->render();

        return response()->json([
            'status' => 'success',
            'html'   => $html,
            'message' => 'Products updated successfully!',
        ]);
    }

    function decryptAttributeValues($encryptedValues)
    {
        return array_map('base64_decode', explode(',', $encryptedValues));
    }
}
