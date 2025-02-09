<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create a category
        $category = Category::firstOrCreate(['name' => 'Ceramic Tiles'], ['slug' => 'ceramic-tiles']);

        // Create a brand
        $brand = Brand::firstOrCreate(['name' => 'Luxury Ceramics'], ['slug' => 'luxury-ceramics'], ['status' => 'active']);

        // Product data
        $products = [
            ['name' => 'Porcelain Floor Tile', 'status' => 'active', 'slug' => 'porcelain-floor-tile', 'price' => 29.99],
            ['name' => 'Handmade Ceramic Vase', 'status' => 'active', 'slug' => 'handmade-ceramic-vase', 'price' => 49.99],
            ['name' => 'Mosaic Wall Tiles', 'status' => 'active', 'slug' => 'mosaic-wall-tiles', 'price' => 39.99],
            ['name' => 'Hand-Painted Ceramic Plate', 'status' => 'active', 'slug' => 'hand-painted-ceramic-plate', 'price' => 19.99],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'name' => $productData['name'],
                'slug' => $productData['slug'],
                'price' => $productData['price'],
                'status' => 'active',
            ]);

            // Attach random attributes
            $attributeIds = Attribute::inRandomOrder()->limit(rand(1, 4))->pluck('id');
            foreach ($attributeIds as $attributeId) {
                $attributeValueId = AttributeValue::where('attribute_id', $attributeId)
                    ->inRandomOrder()
                    ->limit(1)
                    ->pluck('id')
                    ->first();

                if ($attributeValueId) {
                    DB::table('product_attribute_values')->insert([
                        'product_id' => $product->id,
                        'attribute_id' => $attributeId,
                        'attribute_value_id' => $attributeValueId,
                    ]);
                }
            }
        }
    }
}
