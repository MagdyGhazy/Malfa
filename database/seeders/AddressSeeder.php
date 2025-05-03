<?php

namespace Database\Seeders;

use App\Models\Address;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            [
                'model_id' => 1,
                'model_type' => 'App\Models\User',
                'address_line_en' => '123 Main Street',
                'address_line_ar' => 'الشارع الرئيسي 123',
                'city_id' => 1,
                'country_id' => 1,
                'lat' => '30.033',
                'long' => '31.233',
                'zip_code' => '12345',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'model_id' => 2,
                'model_type' => 'App\Models\User',
                'address_line_en' => '456 Side Road',
                'address_line_ar' => 'الطريق الجانبي 456',
                'city_id' => 2,
                'country_id' => 1,
                'lat' => '30.023',
                'long' => '31.233',
                'zip_code' => '67890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('addresses')->insert($addresses);
    }
}
