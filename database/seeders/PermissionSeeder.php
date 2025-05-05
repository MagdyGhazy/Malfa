<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard'          => ['show'],
            'permissions'        => ['list', 'edit'],
            'users'              => ['list', 'show', 'create', 'edit', 'delete'],
            'roles'              => ['list', 'show', 'create', 'edit', 'delete'],
            'addresses'          => ['list', 'show', 'create', 'edit', 'delete'],
            'countries'          => ['list', 'show'],
            'features' => ['list', 'show', 'create', 'edit', 'delete'],
            'landings'           => ['list', 'show', 'create', 'edit', 'delete'],
            'units'              => ['list', 'show', 'create', 'edit', 'delete'],
        ];

        foreach ($permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action} {$module}",
                ]);
            }
        }
    }
}
