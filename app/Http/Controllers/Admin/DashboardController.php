<?php

namespace App\Http\Controllers\Admin;

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
