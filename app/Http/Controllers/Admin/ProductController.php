<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Enum\StatusEnum;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Variation;
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
            'active' => 'products',
        ];

        return view('admin.product.edit', $data);
    }



    public function update(Request $request, Product $product)
    {
        // dd($request->all());

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
            //            $product->attributes()->delete();
            if ($request['attributes'] != null) {
                foreach ($request['attributes'] as $attr) {
                    if (isset($attr['id']) && $attr['id'] != null) {
                        $attribute = $product->attributes()->find($attr['id']);
                        $attribute->update([
                            'name' => $attr['name']
                        ]);
                    } else {
                        $attribute = $product->attributes()->create([
                            'name' => $attr['name']
                        ]);
                    }
                    $values = array_map('trim', explode(',', $attr['values']));
                    $attribute->values()->delete();
                    foreach ($values as $val) {
                        if ($val !== '') {
                            $attribute->values()->create([
                                'value' => $val
                            ]);
                        }
                    }
                }
            }

            if ($this->hasNewVariations($request->variations)) {
                // dd('has new variations');
                $this->deleteVariations($product->variations);
            }
            $existing_variations = $product->variations()->pluck('id')->toArray();
            $variationIds = collect($request->variations)->pluck('variation_id');
            $notCommon = collect($existing_variations)->diff($variationIds)->values()->all();
            if (count($notCommon) > 0) {
                $variations = $product->variations()->whereIn('id', $notCommon)->get();
                foreach ($variations as $variation) {
                    foreach ($variation->images as $image) {
                        $filePath = preg_replace('/^storage\//', '', $image->path);
                        if (Storage::exists($filePath)) {
                            Storage::delete($filePath);
                        }
                    }
                    $variation->delete();
                }
            }


            foreach ($request->variations ?? [] as $variation) {
                if ($variation['variation_id'] != null) {
                    $variation_data = $product->variations()->find($variation['variation_id']);
                    $variation_data->update([
                        'attribute_string' => $variation['attributes'],
                        'price' => $variation['price']
                    ]);
                } else {
                    $variation_data = $product->variations()->create([
                        'attribute_string' => $variation['attributes'],
                        'price' => $variation['price']
                    ]);
                }
                if (isset($variation['images']) && $variation['images'] != null) {
                    foreach ($variation['images'] as $image) {
                        $fileInfo = uploadImage($image, 'products');
                        $variation_data->images()->create([
                            'name' => $fileInfo['name'],
                            'path' => $fileInfo['path'],
                        ]);
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

    private function hasNewVariations($variations)
    {
        foreach ($variations as $variation) {
            if ($variation['variation_id'] != null) {
                return false;
            }
            return true;
        }
    }

    private function deleteVariations($variations)
    {
        foreach ($variations as $variation) {
            foreach ($variation->images as $image) {
                $filePath = preg_replace('/^storage\//', '', $image->path);
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
            $variation->delete();
        }
    }




    // public function update(Request $request, Product $product)
    // {
    //     DB::beginTransaction();

    //     try {
    //         // Step 1: Update core product info
    //         $product->update([
    //             'name' => $request->name,
    //             'slug' => Str::slug($request->name),
    //             'category_id' => $request->category,
    //             'brand_id' => $request->brand,
    //             'regular_price' => $request->regular_price,
    //             'sale_price' => $request->sale_price,
    //             'status' => $request->status,
    //             'short_description' => $request->short_description,
    //             'description' => $request->description,
    //         ]);
    //         // Step 2: Sync product attributes and their values
    //         if (!empty($request['attributes'])) {
    //             foreach ($request['attributes'] as $attr) {
    //                 $attribute = !empty($attr['id'])
    //                     ? $product->attributes()->find($attr['id'])
    //                     : $product->attributes()->create(['name' => $attr['name']]);

    //                 if ($attribute) {
    //                     $attribute->update(['name' => $attr['name']]);
    //                     $attribute->values()->delete();

    //                     $values = array_map('trim', explode(',', $attr['values']));
    //                     foreach ($values as $val) {
    //                         if ($val !== '') {
    //                             $attribute->values()->create(['value' => $val]);
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         // Step 3: Handle variation logic
    //         $existingVariationIds = $product->variations()->pluck('id')->toArray();
    //         $requestVariationIds = collect($request->variations)->pluck('variation_id')->filter()->toArray();

    //         $variationsToDelete = array_diff($existingVariationIds, $requestVariationIds);
    //         $newVariationsExist = $this->hasNewVariations($request->variations);

    //         // Delete all existing variations if entirely new variations are sent
    //         if ($newVariationsExist) {
    //             $this->deleteVariations($product->variations);
    //         } elseif (!empty($variationsToDelete)) {
    //             $variations = $product->variations()->whereIn('id', $variationsToDelete)->get();
    //             $this->deleteVariations($variations);
    //         }

    //         // Step 4: Update or create variations
    //         foreach ($request->variations ?? [] as $variation) {
    //             $variationData = !empty($variation['variation_id'])
    //                 ? $product->variations()->find($variation['variation_id'])
    //                 : null;

    //             if ($variationData) {
    //                 $variationData->update([
    //                     'attribute_string' => $variation['attributes'],
    //                     'price' => $variation['price']
    //                 ]);
    //             } else {
    //                 $variationData = $product->variations()->create([
    //                     'attribute_string' => $variation['attributes'],
    //                     'price' => $variation['price']
    //                 ]);
    //             }

    //             // Attach images if available
    //             if (!empty($variation['images'])) {
    //                 foreach ($variation['images'] as $image) {
    //                     $fileInfo = uploadImage($image, 'products');
    //                     $variationData->images()->create([
    //                         'name' => $fileInfo['name'],
    //                         'path' => $fileInfo['path'],
    //                     ]);
    //                 }
    //             }
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Product updated successfully',
    //             'product' => $product,
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Product Update Failed: ' . $e->getMessage());

    //         return response()->json([
    //             'error' => 'An unexpected error occurred: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // private function hasNewVariations($variations)
    // {
    //     foreach ($variations as $variation) {
    //         if (empty($variation['variation_id'])) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    // private function deleteVariations($variations)
    // {
    //     foreach ($variations as $variation) {
    //         foreach ($variation->images as $image) {
    //             $filePath = preg_replace('/^storage\//', '', $image->path);
    //             if (Storage::exists($filePath)) {
    //                 Storage::delete($filePath);
    //             }
    //         }
    //         $variation->delete();
    //     }
    // }



    // public function update(Request $request, Product $product)
    // {
    //     DB::beginTransaction();

    //     try {
    //         // Step 1: Update core product info
    //         $product->update([
    //             'name' => $request->name,
    //             'slug' => Str::slug($request->name),
    //             'category_id' => $request->category,
    //             'brand_id' => $request->brand,
    //             'regular_price' => $request->regular_price,
    //             'sale_price' => $request->sale_price,
    //             'status' => $request->status,
    //             'short_description' => $request->short_description,
    //             'description' => $request->description,
    //         ]);

    //         // Step 2: Sync product attributes
    //         $existingAttrIds = $product->attributes()->pluck('id')->toArray();
    //         $requestAttrIds = collect($request['attributes'])->pluck('id')->filter()->toArray();
    //         $attributesToDelete = array_diff($existingAttrIds, $requestAttrIds);

    //         // Delete removed attributes and their values
    //         if (!empty($attributesToDelete)) {
    //             foreach ($attributesToDelete as $attrId) {
    //                 $attribute = $product->attributes()->find($attrId);
    //                 if ($attribute) {
    //                     $attribute->values()->delete(); // Delete child values first
    //                     $attribute->delete();           // Then delete the attribute
    //                 }
    //             }
    //         }

    //         // Update or create attributes from request
    //         if (!empty($request['attributes'])) {
    //             foreach ($request['attributes'] as $attr) {
    //                 $attribute = !empty($attr['id'])
    //                     ? $product->attributes()->find($attr['id'])
    //                     : $product->attributes()->create(['name' => $attr['name']]);

    //                 if ($attribute) {
    //                     $attribute->update(['name' => $attr['name']]);
    //                     $attribute->values()->delete();

    //                     $values = array_map('trim', explode(',', $attr['values']));
    //                     foreach ($values as $val) {
    //                         if ($val !== '') {
    //                             $attribute->values()->create(['value' => $val]);
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         // Step 3: Handle variation logic
    //         $existingVariationIds = $product->variations()->pluck('id')->toArray();
    //         $requestVariationIds = collect($request->variations)->pluck('variation_id')->filter()->toArray();

    //         $variationsToDelete = array_diff($existingVariationIds, $requestVariationIds);
    //         $newVariationsExist = $this->hasNewVariations($request->variations);
    //         // Delete all existing variations if new ones are replacing them
    //         if ($newVariationsExist) {
    //             $this->deleteVariations($product->variations);
    //         } elseif (!empty($variationsToDelete)) {
    //             $variations = $product->variations()->whereIn('id', $variationsToDelete)->get();
    //             $this->deleteVariations($variations);
    //         }
    //         // Step 4: Update or create variations
    //         foreach ($request->variations ?? [] as $variation) {
    //             $variationData = !empty($variation['variation_id'])
    //                 ? $product->variations()->find($variation['variation_id'])
    //                 : null;

    //             if ($variationData) {
    //                 $variationData->update([
    //                     'attribute_string' => $variation['attributes'],
    //                     'price' => $variation['price']
    //                 ]);
    //             } else {
    //                 $variationData = $product->variations()->create([
    //                     'attribute_string' => $variation['attributes'],
    //                     'price' => $variation['price']
    //                 ]);
    //             }

    //             // Upload and attach images if present
    //             if (!empty($variation['images'])) {
    //                 foreach ($variation['images'] as $image) {
    //                     $fileInfo = uploadImage($image, 'products');
    //                     $variationData->images()->create([
    //                         'name' => $fileInfo['name'],
    //                         'path' => $fileInfo['path'],
    //                     ]);
    //                 }
    //             }
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Product updated successfully',
    //             'product' => $product,
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Product Update Failed: ' . $e->getMessage());

    //         return response()->json([
    //             'error' => 'An unexpected error occurred: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // // Check if any new variation is being added (no variation_id)
    // private function hasNewVariations($variations)
    // {
    //     foreach ($variations as $variation) {
    //         if (empty($variation['variation_id'])) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    // // Delete variations along with their images
    // private function deleteVariations($variations)
    // {
    //     foreach ($variations as $variation) {
    //         foreach ($variation->images as $image) {
    //             $filePath = preg_replace('/^storage\//', '', $image->path);
    //             if (Storage::exists($filePath)) {
    //                 Storage::delete($filePath);
    //             }
    //         }
    //         $variation->delete();
    //     }
    // }






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
