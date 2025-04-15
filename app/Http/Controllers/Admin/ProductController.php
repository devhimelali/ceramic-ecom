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
            $data = Product::with(['images', 'category', 'brand', 'attributes' => function ($query) {
                $query->with('values');
            }])->orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = $row->images->where('type', 'thumbnail')->first();
                    $imageUrl = $image
                        ? asset('storage/uploads/products/thumbnail/' . $image->image)
                        : "https://ui-avatars.com/api/?name=" . urlencode($row->name);

                    return '<img class="rounded-circle header-profile-user" src="' . $imageUrl . '" alt="' . e($row->name) . '" width="50" height="50">';
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name;
                })
                ->addColumn('brand', function ($row) {
                    return $row->brand->name ?? 'N/A';
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
        $data = [
            'categories' => $categories,
            'brands' => $brands,
            'statuses' => $statuses,
            'active' => 'products',

        ];
        return view('admin.new-products.create', $data);
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

            // 2. Handle Attributes
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
            // 3. Handle Variations
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
        $product = Product::with(['category', 'brand', 'attributes.values', 'variations'])->findOrFail($id);
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



    public function update(Request $request, Product $product)
    {
        dd($request->all());
        DB::beginTransaction();

        try {
            // 1. Update Product Info
            $product->update([
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

            // 2. Sync Attributes
            $product->attributes()->delete();
            if ($request['attributes'] != null) {
                foreach ($request->attributes ?? [] as $attr) {
                    $attribute = $product->attributes()->create([
                        'name' => $attr['name'],
                    ]);

                    $values = array_map('trim', explode(',', $attr['values']));
                    foreach ($values as $val) {
                        if ($val !== '') {
                            $attribute->values()->create(['value' => $val]);
                        }
                    }
                }
            }

            // 3. Sync Variations
            foreach ($request->variations ?? [] as $variation) {
                $attributeString = $variation['attributes'];

                // Update or create variation
                $variationModel = $product->variations()->updateOrCreate(
                    ['attribute_string' => $attributeString],
                    ['price' => $variation['price']]
                );

                // Handle preserved existing images
                $keepImageIds = $variation['existing_images'] ?? [];
                $variationModel->images()->whereNotIn('id', $keepImageIds)->each(function ($image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                });

                // Handle new uploaded images
                if (!empty($variation['images']) && is_array($variation['images'])) {
                    foreach ($variation['images'] as $image) {
                        if ($image && $image->isValid()) {
                            $fileInfo = uploadImage($image, 'products');
                            $variationModel->images()->create([
                                'name' => $fileInfo['name'],
                                'path' => $fileInfo['path'],
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
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
