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
                'type'    => [1, 2, 3],
            ],
            [
                'name_en' => 'Size',
                'name_ar' => 'الحجم',
                'type'    => [4, 5, 6, 7],
            ],
            [
                'name_en' => 'Material',
                'name_ar' => 'الخامة',
                'type'    => [8, 9, 10],
            ],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
