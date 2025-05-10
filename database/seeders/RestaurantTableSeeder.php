<?php

namespace Database\Seeders;

use App\Models\RestaurantTable;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            RestaurantTable::create([
                'restaurant_id'   => rand(1, 3),
                'capacity'        => rand(2, 10),
                'description_en'  => 'Table description ' . $i,
                'description_ar'  => 'وصف الطاولة ' . $i,
                'is_available'    => 1,
            ]);
        }
    }
}
