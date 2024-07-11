<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $faker = Faker::create('id_ID');

        // Seeder for admin
        $adminUser = User::create([
            'name' => 'Admin Ferdy',
            'email' => 'admin@admin.com',
            'phone' => $faker->unique()->phoneNumber,
            'date_of_birth' => $faker->date(),
            'place_of_birth' => $faker->city,
            'province_id' => $faker->randomNumber(),
            'city_id' => $faker->randomNumber(),
            'subdistrict_id' => $faker->randomNumber(),
            'address_detail' => $faker->address,
            'number_id' => $faker->unique()->randomNumber(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        // Assign role
        $adminUser->assignRole($adminRole);
    }
}
