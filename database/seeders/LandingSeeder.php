<?php

namespace Database\Seeders;

use App\Models\Landing;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0 ;$i <3 ;$i++){
        Landing::create([
            'description_en' => "Description in English . $i",
            'description_ar' => "الوصف بالعربية - تكرار .$i"

        ]);
    }

    }
}
