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
            ['name_en' => 'Color', 'name_ar' => 'اللون'],
            ['name_en' => 'Size', 'name_ar' => 'الحجم'],
            ['name_en' => 'Material', 'name_ar' => 'الخامة'],
        ];

        foreach ($features as $i => $feature) {
            Feature::create([
                'name_en'     => $feature['name_en'],
                'name_ar'     => $feature['name_ar'],
                'model_type'  => 'App\Models\Feature',
                'model_id'    => 1,
            ]);
        }
    }
}
