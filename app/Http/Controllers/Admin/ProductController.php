<?php

namespace App\Http\Controllers\Admin;

use App\Enum\ProductLabelEnum;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use App\Enum\StatusEnum;
use App\Models\Category;
use App\Models\Variation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Product\StoreRequest;

class ProductController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with([
                'images',
                'category',
                'brand',
                'attributes' => function ($query) {
                    $query->with('values');
                }
            ])->orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = null;
                    if ($row->images) {
                        $image = $row->images->where('imageable_id', $row->id)->where(
                            'imageable_type',
                            'App\Models\Product'
                        )->first();
                    }
                    $imageUrl = $image
                        ? asset($image->path)
                        : "https://ui-avatars.com/api/?name=" . urlencode($row->name);

                    return '<img class="rounded-circle header-profile-user" src="' . $imageUrl . '" alt="' . e($row->name) . '" width="50" height="50">';
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
                    $html .= '<a href="' . route(
                        'products.edit',
                        $row->id
                    ) . '" class="btn btn-sm btn-secondary"><i class="ph-pencil"></i> Edit</a>';
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
            'labels' => ProductLabelEnum::cases(),

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
            if ($request->hasFile('image')) {
                $fileInfo = uploadImage($request->file('image'), 'products');
                $product->images()->create([
                    'name' => $fileInfo['name'],
                    'path' => $fileInfo['path'],
                ]);
            }
            // 3. Handle upload product gallery images
            if ($request->hasFile('images')) {
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
        $product = Product::with(['category', 'brand', 'attributes.values', 'variations'])->findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        $statuses = StatusEnum::cases();
        $data = [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'statuses' => $statuses,
            'labels' => ProductLabelEnum::cases(),
            'active' => 'products',
        ];

        return view('admin.product.edit', $data);
    }

    /*************  ✨  Update method 🌟  *************/
    public function update(Request $request, Product $product)
    {
        DB::beginTransaction();

        try {
            // 1. Update basic product information
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

            if ($request->hasFile('image')) {
                if ($product->images && $product->images->count() > 0) {
                    foreach ($product->images as $image) {
                        $filePath = preg_replace('/^storage\//', '', $image->path);

                        if (Storage::disk('public')->exists($filePath)) {
                            Storage::disk('public')->delete($filePath);
                        }

                        $image->delete();
                    }
                }
                $fileInfo = uploadImage($request->file('image'), 'products');
                $product->images()->create([
                    'name' => $fileInfo['name'],
                    'path' => $fileInfo['path'],
                ]);
            }


            // 2. Sync attributes and values
            if (!empty($request['attributes'])) {
                // Extract new attribute IDs from request
                $newAttributeIds = array_filter(array_column($request['attributes'], 'id'));
                $existingAttributeIds = $product->attributes()->pluck('id')->toArray();

                // Delete removed attributes
                $attributesToDelete = array_diff($existingAttributeIds, $newAttributeIds);
                $product->attributes()->whereIn('id', $attributesToDelete)->delete();

                // Loop through each attribute
                foreach ($request['attributes'] as $attr) {
                    // If attribute exists, update it
                    if (!empty($attr['id'])) {
                        $attribute = $product->attributes()->find($attr['id']);
                        if ($attribute) {
                            $attribute->update(['name' => $attr['name']]);
                        }
                    } else {
                        // Create new attribute
                        $attribute = $product->attributes()->create([
                            'name' => $attr['name']
                        ]);
                    }

                    // Sync values
                    if ($attribute) {
                        $attribute->values()->delete(); // Clear old values
                        $values = array_map('trim', explode(',', $attr['values']));
                        foreach ($values as $value) {
                            if ($value !== '') {
                                $attribute->values()->create(['value' => $value]);
                            }
                        }
                    }
                }
            }

            // 3. Handle variations
            $incomingVariationIds = array_filter(array_column($request->variations, 'variation_id'));
            $newVariations = collect($request->variations)->filter(fn($item) => is_null($item['variation_id']))->values();

            // Delete removed variations
            foreach ($product->variations as $existingVar) {
                if (!in_array($existingVar->id, $incomingVariationIds)) {
                    $this->deleteVariations($existingVar);
                }
            }

            // Update or create variations
            foreach ($request->variations as $variationInput) {
                if (!empty($variationInput['variation_id'])) {
                    // Update existing variation
                    $variation = $product->variations()->find($variationInput['variation_id']);
                    if ($variation) {
                        $variation->update([
                            'attribute_string' => $variationInput['attributes'],
                            'price' => $variationInput['price'],
                        ]);

                        // Handle image uploads
                        if (!empty($variationInput['images'])) {
                            foreach ($variationInput['images'] as $image) {
                                $fileInfo = uploadImage($image, 'products');
                                $variation->images()->create([
                                    'name' => $fileInfo['name'],
                                    'path' => $fileInfo['path'],
                                ]);
                            }
                        }
                    }
                } else {
                    // Create new variation
                    $variation = $product->variations()->create([
                        'attribute_string' => $variationInput['attributes'],
                        'price' => $variationInput['price'],
                    ]);

                    // Upload images
                    if (!empty($variationInput['images'])) {
                        foreach ($variationInput['images'] as $image) {
                            $fileInfo = uploadImage($image, 'products');
                            $variation->images()->create([
                                'name' => $fileInfo['name'],
                                'path' => $fileInfo['path'],
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully',
                'product' => $product,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product Update Failed: ' . $e->getMessage());

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function deleteVariations($variation)
    {
        if ($variation->images->isNotEmpty()) {
            foreach ($variation->images as $image) {
                $filePath = preg_replace('/^storage\//', '', $image->path);
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $image->delete();
            }
        }
        $variation->delete();
        return true;
    }
    /*************  ✨  Update method End 🌟  *************/

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::with(['images', 'variations'])->findOrFail($id);
            foreach ($product->images as $image) {
                $filePath = preg_replace('/^storage\//', '', $image->path);
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $image->delete();
            }

            foreach ($product->variations as $variation) {
                $images = Image::where('imageable_id', $variation->id)->where('imageable_type', Variation::class)->get();
                foreach ($images as $image) {
                    $filePath = preg_replace('/^storage\//', '', $image->path);
                    // Delete image file
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                    $image->delete();
                }
            }
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
        $request->validate([
            'id' => 'required|integer|exists:images,id'
        ]);
        $image =  Image::findOrFail($request->id);
        $filePath = preg_replace('/^storage\//', '', $image->path);
        // Delete image file
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
        // Delete record
        $image->delete();

        return response()->json(['status' => 'success']);
    }

    public function getVariations(Request $request)
    {
        $productId = $request->product_id;
        $combinations = $request->combinations; // array of attribute_string like "Size: M / Color: Red"
        $variations = Variation::with('images')->where('product_id', $productId)
            ->whereIn('attribute_string', $combinations)
            ->get()
            ->keyBy('attribute_string');

        return response()->json($variations);
    }
}
