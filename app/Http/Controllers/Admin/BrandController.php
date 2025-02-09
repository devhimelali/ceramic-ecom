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
use App\Http\Requests\Admin\Brand\UpdateRequest;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset($row->image) . '" class="rounded-circle header-profile-user">';
                    } else {
                        return '<img src="https://ui-avatars.com/api/?name='. urlencode($row->name) .  '" class="rounded-circle header-profile-user">';
                    }
                })
                ->addColumn('description', function ($row) {
                    return $row->description ? Str::limit($row->description, 50) : 'N/A';
                })
                ->addColumn('status', function ($row) {
                    return $row->status->value == 'active' ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-danger">Inactive</span>';
                })
                ->addColumn('actions', function ($row) {
                    $deleteUrl = route('brands.destroy', $row->slug);
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

                ->rawColumns(['status', 'actions', 'image'])
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
        $request->validate([
            'name' => 'required|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        $imagePath  = null;
        if ($request->image) {
            $imagePath = ImageUploadHelper::uploadImage($request->image, 'uploads/brands');
        }

        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
            'image' => $imagePath,
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

    public function update(UpdateRequest $request, $slug)
    {
        $brand = Brand::where('slug', $slug)->first();
        $imagePath  = null;
        if ($request->image) {
            if ($brand->image && file_exists(public_path($brand->image))) {
                unlink(public_path($brand->image));
            }
            $imagePath = ImageUploadHelper::uploadImage($request->image, 'uploads/brands');
        } else {
            $imagePath = $brand->image;
        }
        $brand->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'imagepath' => $imagePath
        ]);
    }

    public function destroy($slug)
    {
        $brand = Brand::where('slug', $slug)->first();
        if (!$brand) {
            return response()->json(['success' => false], 404);
        }
        if ($brand->image && file_exists(public_path($brand->image))) {
            unlink(public_path($brand->image));
        }
        $brand->delete();
        return response()->json(['success' => true]);
    }
}
