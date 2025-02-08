<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tiles',
                'image' => 'categories/tiles.jpg',
                'is_active' => 1,
                'children' => [
                    ['name' => 'Wall Tiles', 'image' => ''],
                    ['name' => 'Floor Tiles', 'image' => ''],
                    ['name' => 'Mosaic Tiles', 'image' => ''],
                ],
            ],
            [
                'name' => 'Sanitary Ware',
                'image' => 'categories/sanitary_ware.jpg',
                'is_active' => 1,
                'children' => [
                    ['name' => 'Wash Basins', 'image' => ''],
                    ['name' => 'Toilets', 'image' => ''],
                    ['name' => 'Urinals', 'image' => ''],
                ],
            ],
            [
                'name' => 'Bathroom Accessories',
                'image' => 'categories/bathroom_accessories.jpg',
                'is_active' => 1,
                'children' => [
                    ['name' => 'Soap Holders', 'image' => ''],
                    ['name' => 'Towel Racks', 'image' => ''],
                    ['name' => 'Mirrors', 'image' => ''],
                ],
            ],
            [
                'name' => 'Kitchen Sinks',
                'image' => 'categories/kitchen_sinks.jpg',
                'is_active' => 1,
                'children' => [
                    ['name' => 'Single Bowl', 'image' => ''],
                    ['name' => 'Double Bowl', 'image' => ''],
                    ['name' => 'Farmhouse Sinks', 'image' => ''],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $parent = Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'image' => $categoryData['image'],
                'is_active' => $categoryData['is_active'],
                'parent_id' => null
            ]);

            if (!empty($categoryData['children'])) {
                foreach ($categoryData['children'] as $childData) {
                    Category::create([
                        'name' => $childData['name'],
                        'slug' => Str::slug($childData['name']),
                        'image' => $childData['image'],
                        'is_active' => 1,
                        'parent_id' => $parent->id
                    ]);
                }
            }
        }
    }
}
