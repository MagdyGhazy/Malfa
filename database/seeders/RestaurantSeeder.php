<?php

namespace Database\Seeders;

use App\Models\Restaurant;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <=3; $i++) {
            Restaurant::create([
                'user_id' => 1,
                'name' => "Restaurant $i",
                'description_en' => "This is a description for Restaurant $i",
                'description_ar' => "هذا وصف للمطعم $i",
                'rating' => rand(1, 5),
                'opening_time' => '10:00',
                'closing_time' => '22:00',
                'available_tables' => [2, 4, 6],
                'status' => 1,
            ]);
        }
    }
}
