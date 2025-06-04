<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Review;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $productIds = Product::pluck('id');

        if ($productIds->isEmpty()) {
            $this->command->info('No products found. Please seed products first.');
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            Review::create([
                'product_id' => $faker->randomElement($productIds),
                'rating' => $faker->numberBetween(1, 5),
                'comment' => $faker->paragraph,
                'headline' => $faker->sentence,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'is_approved' => $faker->boolean(80),
            ]);
        }
    }
}
