<?php

namespace App\Http\Controllers\Admin;


use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductQuery;
use App\Models\Variation;
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
use App\Mail\MultipleProductQuerySubmittedMail;
use App\Mail\ProductQuerySubmittedMailForAdmin;
use App\Mail\AdminMultipleProductQueryNotificationMail;

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
        $product = Product::with('images', 'attributes', 'variations.images')->where('id', $productId)->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

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

        // Render the view with the result
        $html = view('frontend.products.enquire-modal', compact('productId', 'product', 'attributes'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }
    public function addToCart($id)
    {
        $product = Product::with('images', 'attributes', 'variations.images')->where('id', $id)->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

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
        // Render the view with the result
        $html = view('frontend.products.add-to-modal', compact('product', 'attributes'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }


    public function storeSingleProductQuery(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'variation' => 'required'
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
            'product_id' => $product->id,
            'quantity' => 1,
            'variation_name' => $request->variation
        ]);


        Mail::to($request->email)->send(new ProductQuerySubmittedMail([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'product_name' => $product->name,
            'variations' => $request->variation
        ]));

        Mail::to(env('ADMIN_MAIL'))->send(new AdminProductQueryNotificationMail([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'product_name' => $product->name,
            'variations' => $request->variation
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Query submitted successfully. A confirmation email has been sent.'
        ]);
    }

    public function productQueries(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductQuery::latest();
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

    public function submitCart(Request $request)
    {
        $cartItems = json_decode($request->cartItems, true);

        $request->merge(['cartItems' => $cartItems]);
        // dd($request->all());
        $request->validate([
            'cartItems' => 'required|array',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);

        $productQuery = ProductQuery::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => ProductQueryStatus::PENDING
        ]);

        foreach ($request->cartItems as $item) {
            $product = Product::findOrFail($item['id']);

            $productQueryItem = $productQuery->items()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'variation_name' => $item['variation']
            ]);
        }

        Mail::to($request->email)->send(new MultipleProductQuerySubmittedMail([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'cartItems' => $request->cartItems,
        ]));

        Mail::to(env('ADMIN_MAIL'))->send(new AdminMultipleProductQueryNotificationMail([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'cartItems' => $request->cartItems,
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Query submitted successfully. A confirmation email has been sent.'
        ]);
    }

    public function getProductVariationPrice(Request $request, $id)
    {
        $variationArray = explode(" / ", trim($request->variation));
        $cleanedArray = array_map('trim', $variationArray);
        sort($cleanedArray);
        $formatted = implode(" / ", $cleanedArray);

        $variation = Variation::with('images')
            ->where('product_id', $id)
            ->where(function ($query) use ($formatted, $request) {
                $query->where('attribute_string', $formatted)
                    ->orWhere('attribute_string', $request->variation);
            })
            ->first();

        if ($variation) {
            $images = $variation->images->pluck('path');
            $thumbnail = Image::where('imageable_id', $variation->id)
                ->where('imageable_type', 'App\Models\Variation')
                ->select('path', 'imageable_id', 'imageable_type', 'id')
                ->first();
            // $thumbnail = Image::where('imageable_id', $id)
            //     ->where('imageable_type', Product::class)
            //     ->pluck('path');
            // dd($thumbnail);

            // $new_image = $images->isNotEmpty() ? $images : $thumbnail;
            $new_image = $thumbnail;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'regular_price' => $variation->regular_price,
                    'sale_price' => $variation->sale_price,
                    'images' => $new_image,
                ],
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Variation not found'
        ]);
    }
}
