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
        $query = Product::query();
        if ($request->has('attribute')) {
            $decryptedValues = array_map(function ($value) {
                return base64_decode($value, true);
            }, explode(',', $request->input('attribute')));
            $attributes = $decryptedValues;
            $query->whereHas('attributes', function ($query) use ($attributes) {
                $query->whereIn('product_attribute_values.attribute_value_id', $attributes);
            });
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
}
