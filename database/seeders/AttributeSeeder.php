<?php

namespace Database\Seeders;

use App\Enum\StatusEnum;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $attributes = [
            ['name' => 'Color', 'status' => StatusEnum::ACTIVE],
            ['name' => 'Material', 'status' => StatusEnum::ACTIVE],
            ['name' => 'Finish', 'status' => StatusEnum::ACTIVE],
            ['name' => 'Size', 'status' => StatusEnum::ACTIVE],
        ];

        foreach ($attributes as $attribute) {
            $attr = Attribute::create($attribute);

            // Seed attribute values based on attribute type
            $values = match ($attr->name) {
                'Color' => ['White', 'Black', 'Blue', 'Green', 'Red'],
                'Material' => ['Ceramic', 'Porcelain', 'Glass', 'Marble'],
                'Finish' => ['Glossy', 'Matte', 'Textured', 'Satin'],
                'Size' => ['12x12', '24x24', '36x36', '48x48'],
                default => []
            };

            foreach ($values as $value) {
                AttributeValue::create([
                    'value' => $value,
                    'status' => StatusEnum::ACTIVE,
                    'attribute_id' => $attr->id
                ]);
            }
        }
    }
}
