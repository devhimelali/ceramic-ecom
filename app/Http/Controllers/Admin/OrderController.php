<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\ProductQuery;
use Illuminate\Http\Request;
use App\Enum\ProductQueryStatus;
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

    public function create(OrderRequest $request)
    {
        $order = ProductQuery::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => ProductQueryStatus::PENDING
        ]);
        foreach ($request->product_id as $product_id) {
            $order->productQueryItems()->create([
                'product_id' => $product_id
            ]);
        }

        return redirect()->back()->with('success', 'Order created successfully');
    }
}
