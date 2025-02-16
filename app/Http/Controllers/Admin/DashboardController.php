<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\ProductQuery;
use Illuminate\Http\Request;
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
            'productQuery' => $productQuery // Pass query result to the view
        ];

        return view('admin.dashboard', $data);
    }
}
