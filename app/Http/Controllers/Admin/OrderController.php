<?php

namespace App\Http\Controllers\Admin;


use App\Models\Product;
use App\Models\Category;
use App\Models\ProductQuery;
use Illuminate\Http\Request;
use App\Models\ProductVairants;
use App\Enum\ProductQueryStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Frontend\OrderRequest;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = ProductQuery::query();
            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name ?? '-';
                })
                ->addColumn('phone', function ($row) {
                    return $row->phone ?? '-';
                })
                ->addColumn('message', function ($row) {
                    return $row->message ?? '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->ProductQueryStatus->value ?? '-';
                })

                ->addColumn('actions', function ($row) {
                    return '
                        <div class="btn-group">
                            <a href="javascript:void(0);" class="btn btn-sm btn-secondary">
                                <i class="bi bi-eye me-2"></i>View
                            </a>
                        </div>
                    ';
                })


                ->rawColumns(['actions'])
                ->make(true);
        }

        $data = [
            'active' => 'order',
        ];
        return view('admin.order.index', $data);
    }

    public function store(OrderRequest $request)
    {
        $order = ProductQuery::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => ProductQueryStatus::PENDING
        ]);
        foreach ($request->products as $product_id) {
            $order->productQueryItems()->create([
                'product_id' => $product_id
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully'
        ]);
    }

    // public function enquireForm($productId)
    // {
    //     $product = Product::with('attributes.values')->find(1);


    //     foreach ($product->attributes as $attribute) {
    //         echo $attribute->name . ': ' . $attribute->pivot->attributeValue->value . PHP_EOL;
    //     }
    //     // $attributes = $product->attributes()->get();
    //     // // return $product->attributes;
    //     // $html = view('frontend.products.enquire-modal', compact('productId', 'product', 'attributes'))->render();
    //     // return response()->json([
    //     //     'status' => 'success',
    //     //     'html' => $html
    //     // ]);
    // }
    public function enquireForm($productId)
    {
        // Load the product with attributes and their values
        $product = Product::with(['attributes' => function ($query) {
            $query->distinct()->with(['values']);
        }])->find($productId);

        if (!$product) {
            return "Product not found.";
        }

        // Loop through the attributes and their values
        foreach ($product->attributes as $attribute) {
            // Get the attribute value from the pivot table
            // $attributeValue = $product->attributeValues
            //     ->where('pivot.attribute_id', $attribute->id)
            //     ->first();
            //     return $attributeValue;
            echo $attribute .PHP_EOL;
        }
        // Prepare the result
    $result = [];
// return $product->attributes;
    // Loop through the attributeValues and associate them with their attributes
    // foreach ($product->attributeValues as $attributeValue) {
    //     $attribute = $product->attributes
    //         ->where('id', $attributeValue->pivot->attribute_id)
    //         ->first();

        // if ($attribute) {
        //     $result[] = [
        //         'attribute' => $attribute->name,
        //         'value' => $attributeValue->value,
        //     ];
        // }
    // }

    // return $result;

        // return $product->attributeValues;
    }
}
