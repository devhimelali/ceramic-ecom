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
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $productQuery = ProductQuery::selectRaw('
        MONTH(created_at) as month,
        MONTHNAME(created_at) as month_name,
        COUNT(*) as total
    ')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month', 'month_name') // Include both month and month_name in GROUP BY
            ->orderBy('month')
            ->pluck('total', 'month_name'); // Fetch month name as key and total count as value

        $data = [
            'active' => 'dashboard',
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalBrands' => Brand::count(),
            'totalQueries' => ProductQuery::count(),
            'totalPendingQueries' => ProductQuery::where('status', ProductQueryStatus::PENDING)->count(),
            'pendingQueries' => ProductQuery::where('status', ProductQueryStatus::PENDING)->get(),
            'totalUnreadContact' => ContactUs::where('is_read', 0)->count(),
            'totalPendingReplay' => ContactUs::where('is_replied', 0)->count(),
        ];

        return view('admin.dashboard', $data);
    }
}
