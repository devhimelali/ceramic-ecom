<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        if ($request->ajax()) {
            $categories = Category::with('parent')->select('id', 'name', 'slug', 'image', 'parent_id', 'is_active');

            return DataTables::of($categories)
                ->addColumn('parent', function ($row) {
                    return $row->parent ? $row->parent->name : '-';
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset($row->image) . '" width="50">';
                    } else {
                        return '<img src="' . asset('assets/placeholder-image.webp') . '" width="50">';
                    }
                })
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? '<span class="badge bg-success-subtle text-success text-uppercase">Active</span>' : '<span class="badge bg-danger-subtle text-danger text-uppercase">Inactive</span>';
                })
                ->addColumn('actions', function ($row) {
                    return '

                       <div class="btn-group">
                                <a href="" class="btn btn-sm btn-success edit-item-btn"><i class="bi bi-pencil me-2"></i>Edit</a>
                                <button data-id="' . $row->id . '" class="btn btn-sm btn-danger remove-item-btn"><i
                                        class="bi bi-trash me-2"></i>Delete</button>
                            </div>
                    ';
                })
                ->rawColumns(['is_active', 'actions', 'image'])
                ->make(true);
        }

        $data = [
            'active' => 'category'
        ];
        return view('admin.category.category-index', $data);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        // ]);
        // $imageName = null;
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();

        //     // Store in the 'categories' folder inside storage/app/public
        //     $path = $image->storeAs('categories', $imageName, 'public');
        // }

        // Category::create([
        //     'name' => $request->name,
        //     'slug' => Str::slug($request->name),
        //     'parent_id' => $request->parent_id,
        //     'is_active' => $request->is_active,
        //     'image' => $imageName ? 'storage/categories/' . $imageName : null,
        // ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully'
        ]);
    }
}
