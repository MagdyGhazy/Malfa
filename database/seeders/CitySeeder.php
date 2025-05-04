<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/cities.json');
        $handle = fopen($path, 'r');

        if (!$handle) {
            $this->command->error("Can't open cities.json");
            return;
        }

        $json = fread($handle, filesize($path));
        fclose($handle);

        $citiesRaw = json_decode($json, true);
        if (!$citiesRaw) {
            $this->command->error("Invalid JSON format in cities.json");
            return;
        }

        $chunkSize = 500;
        $batch = [];

        $counter = 0;
        foreach ($citiesRaw as $city) {
            if (!isset($city['name']) || !isset($city['country_id']) || !$city['name'] || !$city['country_id'] ||  !$city['state_id']) {
                continue;
            }

            $batch[] = [
                'country_id' => $city['country_id'],
                'state_id' => $city['state_id'],
                'name' => $city['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batch) >= $chunkSize) {
                DB::table('cities')->insert($batch);
                $batch = [];
                $counter += $chunkSize;
                $this->command->info("Inserted $counter cities...");
            }
        }
        if (!empty($batch)) {
            DB::table('cities')->insert($batch);
        }
    }
}

