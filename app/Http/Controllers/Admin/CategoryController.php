<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('children')->whereNull('parent_id')->orderBy('name', 'asc')->get();
        if ($request->ajax()) {
            $categories = Category::with('parent')->select('id', 'name', 'slug', 'image', 'parent_id', 'is_active', 'front_show');
            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('front_show', function ($row) {
                    $url = route('category.frontShow', $row->id);
                    $checked = $row->front_show == 1 ? 'checked' : '';

                    return '
                        <a href="javascript:void(0);" onclick="return frontShow(\'' . $url . '\')">
                            <div class="form-check form-switch-info form-switch">
                                <input class="form-check-input front_show-toggle" type="checkbox" ' . $checked . '>
                            </div>
                        </a>
                    ';
                })
                ->addColumn('parent', function ($row) {
                    return $row->parent ? $row->parent->name : '-';
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset($row->image) . '" width="50">';
                    } else {
                        return '<img src="' . asset('assets/placeholder-image-2.png') . '" width="50">';
                    }
                })
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? '<span class="badge bg-success-subtle text-success text-uppercase">Active</span>' : '<span class="badge bg-danger-subtle text-danger text-uppercase">Inactive</span>';
                })
                ->addColumn('actions', function ($row) {
                    $deleteUrl = route('categories.destroy', $row->slug);
                    return '
                        <div class="btn-group">
                            <a href="javascript:void(0);" onclick="editCategory(\'' . $row->slug . '\')" class="btn btn-sm btn-success edit-item-btn">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a>
                            <button onclick="confirmDelete(\'' . $row->slug . '\', \'' . $deleteUrl . '\')" class="btn btn-sm btn-danger remove-item-btn">
                                <i class="bi bi-trash me-2"></i>Delete
                            </button>
                        </div>
                    ';
                })


                ->rawColumns(['is_active', 'actions', 'image', 'front_show'])
                ->make(true);
        }

        $data = [
            'active' => 'category',
            'categories' => $categories
        ];
        return view('admin.category.category-index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
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
            'image' => $imagePath ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully'
        ]);
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $parent_categories = Category::whereNull('parent_id')->get();
        return view('admin.category.category-edit', compact('category', 'parent_categories'));
    }

    public function update(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        $imagePath  = null;
        if ($request->image) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            $imagePath = ImageUploadHelper::uploadImage($request->image, 'uploads/categories');
        } else {
            $imagePath = $category->image;
        }
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

    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return response()->json(['success' => false], 404);
        }
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        $category->delete();
        return response()->json(['success' => true]);
    }

    function frontShow($id)
    {
        $category = Category::find($id);
        if ($category->front_show == 1) {
            $category->front_show = 0;
        } else {
            $category->front_show = 1;
        }
        $category->save();
        return response()->json(['status' => 'success', 'message' => 'Status updated successfully!']);
    }
}
