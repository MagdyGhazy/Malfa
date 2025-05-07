<?php

namespace Database\Seeders;

use App\Http\Enums\StatusEnum;
use App\Http\Enums\UnitTypeEnum;
use App\Models\Unit;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <=3; $i++) {
            Unit::create([
                'user_id'         => $i,
                'name'            => "Unit $i",
                'description_en'  => "Test description EN for unit $i",
                'description_ar'  => "وصف تجريبي للوحدة $i",
                'type'            => UnitTypeEnum::HOTEL->value,
                'rating'          => rand(1, 5),
                'status'          => StatusEnum::INACTIVE->value,
                'available_rooms' => [1, 2, 3],
            ]);
        }

    }
}
