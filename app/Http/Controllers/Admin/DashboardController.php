<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
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

    public function reviews(Request $request)
    {
        if ($request->ajax()) {
            $data = Review::select('reviews.*', 'products.name as product_name')
                ->leftJoin('products', 'reviews.product_id', '=', 'products.id')
                ->with('images')
                ->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && $request->search['value']) {
                        $keyword = strtolower($request->search['value']);
                        $query->where(function ($q) use ($keyword) {
                            $q->whereRaw('LOWER(reviews.name) like ?', ["%{$keyword}%"])
                            ->orWhereRaw('LOWER(reviews.comment) like ?', ["%{$keyword}%"])
                            ->orWhereRaw('LOWER(products.name) LIKE ?', ["%{$keyword}%"]);
                        });
                    }
                })
                ->addColumn('product', function ($row) {
                    return $row->product_name ?? 'N/A';
                })
                ->addColumn('name', function ($row) {
                    $name = $row->name ?? 'N/A';
                    if (isset($row->rating)) {
                        $stars = '';
                        for ($i = 0; $i < $row->rating; $i++) {
                            $stars .= '<i class="bi bi-star-fill text-warning"></i>';
                        }
                        for ($i = $row->rating; $i < 5; $i++) {
                            $stars .= '<i class="bi bi-star text-secondary"></i>';
                        }
                        $name = '<div class="d-flex align-items-center"><span class="">' . e($name) . '</span></div><div>' . $stars . '</div>';
                    } else {
                        $name = '<span class="text-secondary">' . e($name) . '</span>';
                    }
                    return $name;
                })
                ->addColumn('comment', function ($row) {
                    $comment = "";
                    if (isset($row->comment) && strlen($row->comment) > 100) {
                        $comment = substr($row->comment, 0, 100) . '...';
                    }
                    if (is_null($row->comment)) {
                        $comment = 'N/A';
                    }
                    $comment = $row->comment ?? 'N/A';
                    return '<div class="text-truncate" style="max-width: 200px;"><small>' . e($comment) . '</small></div>';
                })
                ->addColumn('images', function ($row) {
                    $images = $row->images ?? collect();
                    $imageContainer = '<div class="d-flex align-items-center">';

                    foreach ($images as $img) {
                        $imageUrl = asset($img->path);
                        $imageContainer .= '<img class="rounded-circle header-profile-user me-1" src="' . $imageUrl . '" alt="' . e($row->name) . '" width="50" height="50">';
                    }
                    $imageContainer .= '</div>';
                    return $imageContainer;
                })
                ->addColumn('actions', function ($row) {
                    $buttons = '<div class="btn-group">';
                    if ($row->is_approved === 0) {
                        $buttons .= '
                        <button type="button" class="btn btn-sm btn-primary approvedBtn" data-status="0" data-id="' . $row->id . '">
                            Approve
                        </button>';
                    }

                    if ($row->is_approved === 1) {
                        $buttons .= '
                            <button type="button" class="btn btn-sm btn-secondary approvedBtn" data-status="1" data-id="' . $row->id . '">
                                Reject
                            </button>';
                    }
                    if ($row->is_approved === 2) {
                        $buttons .= '
                            <button type="button" class="btn btn-sm btn-warning approvedBtn" data-status="2" data-id="' . $row->id . '">
                                Rejected
                            </button>';
                    }
                    $buttons .= '
                            <button type="button" class="btn btn-sm btn-danger delete-item-btn" data-id="' . $row->id . '">
                                Delete
                            </button>
                            <a href="'.route('reviews.show', $row->id).'" class="btn btn-sm btn-info">
                                View
                            </a></div>';
                    return $buttons;
                })
                ->rawColumns(['actions', 'images', 'comment', 'name', 'product'])
                ->make(true);
        }
        $data = [
            'active' => 'reviews',
        ];
        return view('admin.review.index', $data);
    }

    public function show($id)
    {
        $review = Review::with('images')->findOrFail($id);
        $active = 'reviews';
        $data = [
            'active' => $active,
            'review' => $review,
        ];
        return view('admin.review.details', $data);
    }

    public function approved(Request $request)
    {
        $id = $request->id;
        $review = Review::find($id);
        $review->is_approved = $review->is_approved === 0 ? 1 : 2;
        $review->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Review ' . ($review->is_approved === 1 ? 'approved' : 'rejected') . ' successfully.'
        ]);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $review = Review::find($id);
        $review->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Review deleted successfully.'
        ]);
    }

}
