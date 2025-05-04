<?php

namespace Database\Seeders;

use App\Models\Feature;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'name_en' => 'Color',
                'name_ar' => 'اللون',
                'type'    => ['red', 'blue', 'green'],
            ],
            [
                'name_en' => 'Size',
                'name_ar' => 'الحجم',
                'type'    => ['S', 'M', 'L', 'XL'],
            ],
            [
                'name_en' => 'Material',
                'name_ar' => 'الخامة',
                'type'    => ['cotton', 'polyester', 'leather'],
            ],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
