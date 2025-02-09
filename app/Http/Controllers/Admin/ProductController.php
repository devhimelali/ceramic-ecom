<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Enum\StatusEnum;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;

class ProductController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with(['images', 'category', 'brand', 'attributes' => function ($query) {
                $query->with('values');
            }])->orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = $row->images->where('type', 'thumbnail')->first();
                    $imageUrl = $row->image
                        ? asset('storage/' . $row->image)
                        : "https://ui-avatars.com/api/?name=" . urlencode($row->name);

                    return '<img class="rounded-circle header-profile-user" src="' . $imageUrl . '" alt="' . e($row->name) . '" width="50" height="50">';
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name;
                })
                ->addColumn('brand', function ($row) {
                    return $row->brand->name;
                })
                ->addColumn('status', function ($row) {
                    return $row->status->value == 'active' ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group" role="group" aria-label="Basic example">';
                    $html .= '<a href="' . route('products.edit', $row->id) . '" class="btn btn-sm btn-secondary"><i class="ph-pencil"></i> Edit</a>';
                    $html .= '<button onclick="confirmDelete(\'' . route('products.destroy', $row->id) . '\')" class="btn btn-sm btn-danger remove-item-btn">
                                <i class="bi bi-trash me-2"></i>Delete
                            </button>';
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        $data = [
            'active' => 'products'
        ];
        return view('admin.product.index', $data);
    }

    /**
     * Display the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        $statuses = StatusEnum::cases();
        $attributes = Attribute::where('status', StatusEnum::ACTIVE)->orderBy('name', 'asc')->get();
        $data = [
            'categories' => $categories,
            'brands' => $brands,
            'statuses' => $statuses,
            'active' => 'products',
            'attributes' => $attributes

        ];
        return view('admin.product.create', $data);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'price' => $request->price,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        foreach ($request->variation_names as $key => $variation_name) {
            $product->attributes()->attach([
                $variation_name => ['attribute_value_id' => $request->variation_values[$key]]
            ]);
        }

        if ($request->hasFile('image')) {
            $imageData = ImageUploadHelper::uploadProductImage($request->file('image'), 'products', $product->id);

            $product->images()->create([
                'type' => 'thumbnail',
                'image' => $imageData['filename'],
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageData = ImageUploadHelper::uploadProductImage($image, 'products', $product->id);

                $product->images()->create([
                    'type' => 'gallery',
                    'image' => $imageData['filename'],
                ]);
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
        ]);
    }


    public function edit($id)
    {
        $product = Product::with([
            'images',
            'category',
            'brand',
            'attributes',
            'attributeValues'
        ])->findOrFail($id);
        // return $product;
        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        $statuses = StatusEnum::cases();
        $attributes = Attribute::with('values')->where('status', StatusEnum::ACTIVE)->orderBy('name', 'asc')->get();
        $data = [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'statuses' => $statuses,
            'attributes' => $attributes,
            'active' => 'products',
        ];
        return view('admin.product.edit', $data);
    }


    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::with(['images', 'attributes'])->findOrFail($id);

            $product->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category,
                'brand_id' => $request->brand,
                'price' => $request->price,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            $attributeData = [];

            foreach ($request->variation_names as $key => $variation_name) {
                $attributeData[$variation_name] = ['attribute_value_id' => $request->variation_values[$key]];
            }

            $product->attributes()->sync($attributeData);

            if ($request->hasFile('image')) {
                $oldImage = $product->images->where('type', 'thumbnail')->first();
                if ($oldImage) {
                    ImageUploadHelper::deleteProductImage($oldImage->image, 'products');
                    $oldImage->delete();
                }

                $imageData = ImageUploadHelper::uploadProductImage($request->file('image'), 'products', $product->id);
                $product->images()->create([
                    'type' => 'thumbnail',
                    'image' => $imageData['filename'],
                ]);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageData = ImageUploadHelper::uploadProductImage($image, 'products', $product->id);
                    $product->images()->create([
                        'type' => 'gallery',
                        'image' => $imageData['filename'],
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update product: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::with(['images', 'category', 'brand', 'attributes'])->findOrFail($id);

            // Delete associated images
            if ($product->images->isNotEmpty()) {
                foreach ($product->images as $image) {
                    ImageUploadHelper::deleteProductImage($image->image, 'products');
                    $image->delete();
                }
            }

            // Detach related attributes
            $product->attributes()->detach();

            // Delete the product
            $product->delete();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete product: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteProductImage(Request $request)
    {
        $imageId = $request->input('image_id');
        $productId = $request->input('product_id');
        
        $image = ProductImage::where('id', $imageId)->where('product_id', $productId)->first();

        if ($image) {
            ImageUploadHelper::deleteProductImage($image->image, 'products');
            $image->delete();
            return response()->json(['status' => 'success', 'message' => 'Image deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Image not found.']);
        }
    }
}
