<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ImageUploadHelper;
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
                            <a href="javascript:void(0);" onclick="editCategory(\'' . $row->slug . '\')" class="btn btn-sm btn-success edit-item-btn">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a>
                            <button data-id="' . $row->id . '" class="btn btn-sm btn-danger remove-item-btn">
                                <i class="bi bi-trash me-2"></i>Delete
                            </button>
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
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = ImageUploadHelper::uploadImage($request->image, 'uploads/categories');
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'is_active' => $request->is_active,
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully'
        ]);
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.category.category-edit', compact('category', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        dd($request->all());
        $imagePath  = null;
        if ($request->image) {
            $imagePath = ImageUploadHelper::uploadImage($request->image, 'uploads/categories');
        }
        $category = Category::where('slug', $slug)->first();
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'is_active' => $request->is_active,
            'image' => $imagePath ?? $category->image,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'imagepath' => $imagePath
        ]);
    }
}
