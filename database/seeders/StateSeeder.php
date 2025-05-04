<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/states.json'));
        $statesRaw = json_decode($json, true);

        $states = [];

        foreach ($statesRaw as $state) {
            $states[] = [
                'id' => $state['id'],
                'country_id' => $state['country_id'],
                'name' => $state['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('states')->insert($states);
    }
}
