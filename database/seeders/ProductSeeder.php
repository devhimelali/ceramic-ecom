<?php

namespace Database\Seeders;

use App\Enum\StatusEnum;
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
        // Create categories
        $categories = [
            ['name' => 'Ceramic Tiles', 'slug' => 'ceramic-tiles'],
            ['name' => 'Porcelain Tiles', 'slug' => 'porcelain-tiles'],
            ['name' => 'Handmade Ceramics', 'slug' => 'handmade-ceramics'],
            ['name' => 'Mosaic Tiles', 'slug' => 'mosaic-tiles'],
        ];

        foreach ($categories as $catData) {
            $category = Category::firstOrCreate(
                ['name' => $catData['name']],
                ['slug' => $catData['slug']]
            );
        }

        // Create brands
        $brands = [
            ['name' => 'Luxury Ceramics', 'slug' => 'luxury-ceramics'],
            ['name' => 'Elegant Tiles', 'slug' => 'elegant-tiles'],
            ['name' => 'Handcrafted Designs', 'slug' => 'handcrafted-designs'],
        ];

        foreach ($brands as $brandData) {
            $brand = Brand::firstOrCreate(
                ['name' => $brandData['name']],
                ['slug' => $brandData['slug'], 'status' => StatusEnum::ACTIVE]
            );
        }

        // Product data
        $products = [
            ['name' => 'Porcelain Floor Tile', 'slug' => 'porcelain-floor-tile', 'price' => 29.99],
            ['name' => 'Handmade Ceramic Vase', 'slug' => 'handmade-ceramic-vase', 'price' => 49.99],
            ['name' => 'Mosaic Wall Tiles', 'slug' => 'mosaic-wall-tiles', 'price' => 39.99],
            ['name' => 'Hand-Painted Ceramic Plate', 'slug' => 'hand-painted-ceramic-plate', 'price' => 19.99],
            ['name' => 'Textured Ceramic Tile', 'slug' => 'textured-ceramic-tile', 'price' => 24.99],
            ['name' => 'Rustic Clay Pot', 'slug' => 'rustic-clay-pot', 'price' => 34.99],
            ['name' => 'Glossy White Tiles', 'slug' => 'glossy-white-tiles', 'price' => 45.99],
            ['name' => 'Artisan Ceramic Mug', 'slug' => 'artisan-ceramic-mug', 'price' => 14.99],
        ];

        foreach ($products as $productData) {
            $category = Category::inRandomOrder()->first();
            $brand = Brand::inRandomOrder()->first();

            $product = Product::create([
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'name' => $productData['name'],
                'slug' => $productData['slug'],
                'price' => $productData['price'],
                'status' => StatusEnum::ACTIVE,
            ]);

            // Attach multiple attributes
            $attributeIds = Attribute::inRandomOrder()->limit(rand(2, 5))->pluck('id');
            foreach ($attributeIds as $attributeId) {
                $attributeValueIds = AttributeValue::where('attribute_id', $attributeId)
                    ->inRandomOrder()
                    ->limit(rand(1, 3))
                    ->pluck('id');

                foreach ($attributeValueIds as $attributeValueId) {
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
