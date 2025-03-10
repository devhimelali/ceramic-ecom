<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\ProductQuery;
use Illuminate\Http\Request;
use App\Enum\ProductQueryStatus;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductQuery::where('status', ProductQueryStatus::PENDING);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name ?? 'N/A';
                })
                ->addColumn('phone', function ($row) {
                    return $row->phone ?? 'N/A';
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
            'active' => 'dashboard',
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalBrands' => Brand::count(),
            'totalQueries' => ProductQuery::count(),
            'totalPendingQueries' => ProductQuery::where('status', ProductQueryStatus::PENDING)->count(),
            'totalUnreadContact' => ContactUs::where('is_read', 0)->count(),
            'totalPendingReplay' => ContactUs::where('is_replied', 0)->count(),
            'statuses' => ProductQueryStatus::cases(),
        ];

        return view('admin.dashboard', $data);
    }

    public function getChartData(Request $request)
    {
        $filter = $request->query('filter', '1M'); // Default to last 1 month
        $now = Carbon::now();
    
        switch ($filter) {
            case '1M': // Last 1 month
                $startDate = $now->subMonth();
                break;
            case '6M': // Last 6 months
                $startDate = $now->subMonths(6);
                break;
            case '1Y': // Last 1 year (default)
            default:
                $startDate = $now->subYear();
                break;
        }
    
        // Fetch product query data grouped by day
        $chartData = ProductQuery::whereBetween('created_at', [$startDate, Carbon::now()])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as day, COUNT(*) as total')
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get();
    
        return response()->json($chartData);
    }
    
}
