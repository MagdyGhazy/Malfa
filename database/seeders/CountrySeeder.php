<?php

namespace Database\Seeders;

use App\Models\Country;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/countries.json'));
        $countriesRaw = json_decode($json, true);

        $countries = [];

        foreach ($countriesRaw as $country) {
            $countries[] = [
                'name' => $country['name'],
                'native' => $country['native'] ?? $country['name'],
                'iso_code' => $country['iso2'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('countries')->insert($countries);

    }
}
