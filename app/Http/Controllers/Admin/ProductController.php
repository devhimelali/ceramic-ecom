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
use Illuminate\Support\Facades\Log;
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
            $data = Product::with([
                'images', 'category', 'brand', 'attributes' => function ($query) {
                    $query->with('values');
                }
            ])->orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = null;
                    if ($row->images) {
                        $image = $row->images->where('imageable_id', $row->id)->where('imageable_type',
                            'App\Models\Product')->first();
                    }
                    $imageUrl = $image
                        ? asset($image->path)
                        : "https://ui-avatars.com/api/?name=".urlencode($row->name);

                    return '<img class="rounded-circle header-profile-user" src="'.$imageUrl.'" alt="'.e($row->name).'" width="50" height="50">';
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name;
                })
                ->addColumn('brand', function ($row) {
                    return $row->brand->name ?? 'N/A';
                })
                ->addColumn('regular_price', function ($row) {
                    return $row->regular_price ?? 'N/A';
                })
                ->addColumn('sale_price', function ($row) {
                    return $row->sale_price ?? 'N/A';
                })
                ->addColumn('status', function ($row) {
                    return $row->status->value == 'active' ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group" role="group" aria-label="Basic example">';
                    $html .= '<a href="'.route('products.edit',
                            $row->id).'" class="btn btn-sm btn-secondary"><i class="ph-pencil"></i> Edit</a>';
                    $html .= '<button onclick="confirmDelete(\''.route('products.destroy', $row->id).'\')" class="btn btn-sm btn-danger remove-item-btn">
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
        $data = [
            'categories' => $categories,
            'brands' => $brands,
            'statuses' => $statuses,
            'active' => 'products',

        ];
        return view('admin.product.create', $data);
    }


    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            // 1. Create Product
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category,
                'brand_id' => $request->brand,
                'regular_price' => $request->regular_price,
                'sale_price' => $request->sale_price,
                'status' => $request->status,
                'short_description' => $request->short_description,
                'description' => $request->description,
            ]);
            // 2. Handle upload product thumbnail image
            if($request->hasFile('image')){
                $fileInfo = uploadImage($request->file('image'), 'products');
                $product->images()->create([
                    'name' => $fileInfo['name'],
                    'path' => $fileInfo['path'],
                ]);
            }
            // 3. Handle upload product gallery images
            if($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $fileInfo = uploadImage($image, 'products');
                    $product->images()->create([
                        'name' => $fileInfo['name'],
                        'path' => $fileInfo['path'],
                    ]);
                }
            }
            // 4. Handle Attributes
            if ($request['attributes'] != null) {
                foreach ($request['attributes'] as $attr) {
                    $attribute = $product->attributes()->create([
                        'name' => $attr['name'],
                    ]);

                    $values = array_map('trim', explode(',', $attr['values']));
                    foreach ($values as $val) {
                        $attribute->values()->create([
                            'value' => $val
                        ]);
                    }
                }
            }
            // 5. Handle Variations
            if ($request->has('variations') && is_array($request->variations)) {
                foreach ($request->variations as $variation) {
                    $variationData = $product->variations()->create([
                        'attribute_string' => $variation['attributes'],
                        'price' => $variation['price'],
                    ]);

                    if (isset($variation['images'])) {
                        foreach ($variation['images'] as $image) {
                            $fileInfo = uploadImage($image, 'products');
                            $variationData->images()->create([
                                'name' => $fileInfo['name'],
                                'path' => $fileInfo['path'],
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function edit($id)
    {
        $product = Product::with(['category', 'brand', 'attributes', 'variations'])->findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        $statuses = StatusEnum::cases();
        $data = [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'statuses' => $statuses,
            'active' => 'products',
        ];

        return view('admin.new-products.edit', $data);
    }


    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            // Retrieve product with related images and attributes
            $product = Product::with(['images', 'attributes'])->findOrFail($id);

            // Update product details
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

            $product->attributes()->detach();

            // Attach product attributes and variation values
            foreach ($request->variation_names as $key => $variation_name) {
                $product->attributes()->attach([
                    $variation_name => ['attribute_value_id' => $request->variation_values[$key]]
                ]);
            }

            // Handle thumbnail image update
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

            // Handle additional gallery images
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
                'product' => $product->load(['attributes', 'images']),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product Update Failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update product.',
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
                'message' => 'Failed to delete product: '.$e->getMessage(),
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
