<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Enum\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Brand\StoreRequest;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::where('status', StatusEnum::ACTIVE);
            return DataTables::of($data)
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset($row->image) . '" class="rounded-circle header-profile-user">';
                    } else {
                        return '<img src="' . asset('assets/placeholder-image.webp') . '" class="rounded-circle header-profile-user">';
                    }
                })
                ->addColumn('description', function ($row) {
                    $row->description ? Str::limit($row->description, 50) : 'N/A';
                })
                ->addColumn('status', function ($row) {
                    return $row->status->value == 'active' ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-danger">Inactive</span>';
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

                ->rawColumns(['status', 'actions', 'image', 'description'])
                ->make(true);
        }

        $statuses = StatusEnum::cases();

        $data = [
            'active' => 'brand',
            'statuses' => $statuses
        ];
        return view('admin.brand.index', $data);
    }

    public function store(StoreRequest $request)
    {
        if ($request->image) {
            $imagePath = ImageUploadHelper::uploadImage($request->image, 'uploads/brands');
        }

        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
            'image' => $imagePath ?? null,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Brand created successfully'
        ]);
    }

    public function edit($slug)
    {
        $brand = Brand::where('slug', $slug)->first();
        $statuses = StatusEnum::cases();
        return view('admin.brand.edit', compact('brand', 'statuses'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        $imagePath  = null;
        if ($request->hasFile('image')) {
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
            'message' => 'Category updated successfully'
        ]);
    }
}
