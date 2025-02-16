<?php

namespace App\Http\Controllers\Admin;


use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductQuery;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\ProductVairants;
use App\Enum\ProductQueryStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductQuerySubmittedMail;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Frontend\OrderRequest;
use App\Mail\AdminProductQueryNotificationMail;
use App\Mail\ProductQuerySubmittedMailForAdmin;

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

    public function enquireForm($productId)
    {
        // Load the product with attributes and their values, and also the pivot data (attribute_value_id)
        $product = Product::with(['attributes' => function ($query) {
            $query->withPivot('attribute_value_id'); // Load the pivot column
        }])->find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

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
        // Render the view with the result
        $html = view('frontend.products.enquire-modal', compact('productId', 'product', 'result'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }
    public function addToCart($id)
    {
        // Load the product with attributes and their values, and also the pivot data (attribute_value_id)
        $product = Product::with(['attributes' => function ($query) {
            $query->withPivot('attribute_value_id'); // Load the pivot column
        }])->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

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
        // Render the view with the result
        $html = view('frontend.products.add-to-modal', compact('product', 'result'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }


    public function storeSingleProductQuery(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'variation_values' => 'required|array',
        ]);

        $product = Product::findOrFail($id);

        $productQuery = ProductQuery::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => ProductQueryStatus::PENDING
        ]);

        $productQueryItem = $productQuery->items()->create([
            'product_id' => $product->id
        ]);

        // Remove null values from variation_values
        $filteredVariations = array_filter($request->variation_values, function ($value) {
            return !is_null($value);
        });

        $selectedVariations = [];

        foreach ($filteredVariations as $key => $variation) {
            $attribute = Attribute::where('name', $key)->first();
            $attributeValue = AttributeValue::where('value', $variation)->first();

            if ($attribute && $attributeValue) {
                $selectedVariations[] = [
                    'attribute_id' => $attribute->id,
                    'attribute_value_id' => $attributeValue->id
                ];
            }
        }

        // Attach variations to the ProductQueryItem
        foreach ($selectedVariations as $variation) {
            $productQueryItem->variations()->attach($product->id, $variation);
        }

        Mail::to($request->email)->send(new ProductQuerySubmittedMail([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'product_name' => $product->name,
            'variations' => $filteredVariations
        ]));

        Mail::to($request->email)->send(new AdminProductQueryNotificationMail([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'product_name' => $product->name,
            'variations' => $filteredVariations
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Query submitted successfully. A confirmation email has been sent.'
        ]);
    }

    public function productQueries(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductQuery::query();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name ?? 'N/A';
                })
                ->addColumn('email', function ($row) {
                    return $row->email ?? 'N/A';
                })
                ->addColumn('phone', function ($row) {
                    return $row->phone ?? 'N/A';
                })
                ->addColumn('message', function ($row) {
                    return $row->message ?? 'N/A';
                })
                ->addColumn('status', function ($row) {
                    return $row->status->value == 'completed' ? '<span class="badge text-bg-success">Completed</span>' : ($row->status->value == 'pending' ? '<span class="badge text-bg-warning">Pending</span>' : '<span class="badge text-bg-danger">Cancelled</span>');
                })
                ->addColumn('action', function ($row) {
                    return '
                    <div class="btn-group">
                        <a href="javascript:void(0);" class="btn btn-sm btn-primary change-status" data-id="' . $row->id . '" data-status="' . $row->status->value . '">
                            <i class="bi bi-pencil me-2"></i>Change Status
                        </a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-secondary viewDetails" data-id="' . $row->id . '">
                            <i class="bi bi-eye me-2"></i>View
                        </a>
                    </div>
                ';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        $data = [
            'active' => 'product_query',
            'statuses' => ProductQueryStatus::cases()
        ];
        return view('admin.product_query.index', $data);
    }
    public function viewProductQuery($id)
    {
        $productQuery = ProductQuery::with('items')->findOrFail($id);
        return view('admin.product_query.view', compact('productQuery'));
    }
    public function changeProductQueryStatus(Request $request, $id)
    {
        $productQuery = ProductQuery::findOrFail($id);
        $productQuery->status = $request->status;
        $productQuery->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Status changed successfully'
        ]);
    }
}
