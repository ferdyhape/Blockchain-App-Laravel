<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $regularMemberRole = Role::where('name', 'Regular Member')->first();
        $platinumMemberRole = Role::where('name', 'Platinum Member')->first();

        $faker = \Faker\Factory::create('id_ID');
        // seeder for admin
        $adminUser =
            User::create([
                'name' => 'Admin Ferdy',
                'email' => 'admin@admin.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]);
        // asign role
        $adminUser->assignRole($adminRole);


        // seeder for platinum member
        for ($i = 0; $i < 10; $i++) {
            $userPlatinum =
                User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->email(),
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                ]);
            // asign role
            $userPlatinum->assignRole($platinumMemberRole);
        }

        // seeder for regular member
        for ($i = 0; $i < 10; $i++) {
            $userRegular =
                User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->email(),
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                ]);
            // asign role
            $userRegular->assignRole($regularMemberRole);
        }
    }
}
