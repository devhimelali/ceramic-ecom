<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Enum\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Kajaria Ceramics',
                'slug' => Str::slug('Kajaria Ceramics'),
                'image' => null,
                'description' => 'Kajaria Ceramics is one of the largest manufacturers of ceramic and vitrified tiles in India.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Somany Ceramics',
                'slug' => Str::slug('Somany Ceramics'),
                'image' => null,
                'description' => 'Somany Ceramics is a well-known tile manufacturer offering a wide range of wall and floor tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Johnson Tiles',
                'slug' => Str::slug('Johnson Tiles'),
                'image' => null,
                'description' => 'Johnson Tiles provides high-quality ceramic and porcelain tiles for residential and commercial spaces.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'RAK Ceramics',
                'slug' => Str::slug('RAK Ceramics'),
                'image' => null,
                'description' => 'RAK Ceramics is a UAE-based global brand known for premium ceramic and porcelain tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'NITCO Tiles',
                'slug' => Str::slug('NITCO Tiles'),
                'image' => null,
                'description' => 'NITCO is a leading tile manufacturer in India, specializing in innovative and stylish tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Marazzi Tiles',
                'slug' => Str::slug('Marazzi Tiles'),
                'image' => null,
                'description' => 'Marazzi is an Italian brand famous for high-end ceramic and porcelain tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Mohawk Industries',
                'slug' => Str::slug('Mohawk Industries'),
                'image' => null,
                'description' => 'Mohawk Industries is a US-based flooring company offering premium tile solutions worldwide.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Cotto Tiles',
                'slug' => Str::slug('Cotto Tiles'),
                'image' => null,
                'description' => 'Cotto is a Thai brand known for high-quality ceramic and porcelain tiles with innovative designs.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Varmora Tiles',
                'slug' => Str::slug('Varmora Tiles'),
                'image' => 'uploads/brands/varmora.png',
                'description' => 'Varmora Tiles is an Indian brand specializing in premium vitrified and ceramic tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Orientbell Tiles',
                'slug' => Str::slug('Orientbell Tiles'),
                'image' => null,
                'description' => 'Orientbell Tiles offers a vast collection of stylish and durable ceramic and vitrified tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Bellissimo Tiles',
                'slug' => Str::slug('Bellissimo Tiles'),
                'image' => null,
                'description' => 'Bellissimo Tiles is a luxury tile brand known for elegant and high-end tile designs.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Simpolo Ceramics',
                'slug' => Str::slug('Simpolo Ceramics'),
                'image' => null,
                'description' => 'Simpolo Ceramics is an Indian brand specializing in designer ceramic and vitrified tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Asian Granito',
                'slug' => Str::slug('Asian Granito'),
                'image' => null,
                'description' => 'Asian Granito is one of India’s leading manufacturers of ceramic and vitrified tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Grupo Lamosa',
                'slug' => Str::slug('Grupo Lamosa'),
                'image' => null,
                'description' => 'Grupo Lamosa is a Mexican tile manufacturer known for innovative ceramic and porcelain tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Duragres Tiles',
                'slug' => Str::slug('Duragres Tiles'),
                'image' => null,
                'description' => 'Duragres Tiles is a Thai brand famous for stylish and high-quality tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Italon Tiles',
                'slug' => Str::slug('Italon Tiles'),
                'image' => null,
                'description' => 'Italon is a Russian-Italian brand offering premium porcelain and ceramic tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Emser Tile',
                'slug' => Str::slug('Emser Tile'),
                'image' => null,
                'description' => 'Emser Tile is an American brand offering a wide variety of residential and commercial tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Fiandre Tiles',
                'slug' => Str::slug('Fiandre Tiles'),
                'image' => null,
                'description' => 'Fiandre Tiles is an Italian brand known for its premium large-format porcelain tiles.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Halcon Ceramicas',
                'slug' => Str::slug('Halcon Ceramicas'),
                'image' => null,
                'description' => 'Halcon Ceramicas is a Spanish tile brand recognized for modern and innovative tile solutions.',
                'status' => StatusEnum::ACTIVE
            ],
            [
                'name' => 'Novoceram',
                'slug' => Str::slug('Novoceram'),
                'image' => null,
                'description' => 'Novoceram is a French brand specializing in high-end ceramic and porcelain tiles.',
                'status' => StatusEnum::ACTIVE
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
