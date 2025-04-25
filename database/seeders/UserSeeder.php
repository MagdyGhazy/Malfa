<?php

namespace Database\Seeders;

use App\Http\Enums\UserTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::create([
            'name'              => 'Super Admin',
            'email'             => 'super@admin.com',
            'phone'             => '01021783997',
            'type'              => UserTypeEnum::ADMIN->value,
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $partner = \App\Models\User::create([
            'name'              => 'partner',
            'email'             => 'partner@gmail.com',
            'phone'             => '01512365478',
            'type'              => UserTypeEnum::PARTNER->value,
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $visitor = \App\Models\User::create([
            'name'              => 'visitor',
            'email'             => 'visitor@gmail.com',
            'phone'             => '01512365477',
            'type'              => UserTypeEnum::VISITOR->value,
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $guest = \App\Models\User::create([
            'name'              => 'guest',
            'email'             => 'guest@gmail.com',
            'phone'             => '01512365487',
            'type'              => UserTypeEnum::GUEST->value,
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

//        $admin->assignRole(1);
//        $partner->assignRole(2);
//        $visitor->assignRole(3);
//        $guest->assignRole(4);
    }
}
