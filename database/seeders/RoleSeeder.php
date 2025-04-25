<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name_en' => 'super admin', 'name_ar' => 'مشرف عام'],
            ['name_en' => 'partner',     'name_ar' => 'شريك'],
            ['name_en' => 'visitor',     'name_ar' => 'زائر'],
            ['name_en' => 'guest',       'name_ar' => 'زائر مؤقت'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name_en' => $role['name_en']],
                ['name_ar' => $role['name_ar']]
            );
        }

        $super_admin = Role::where('name_en', 'super admin')->first();
        if ($super_admin) {
            $super_admin->syncPermissions(Permission::query()->get()->pluck('id')->toArray());
        }
    }
}
