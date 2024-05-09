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

        // $table->uuid('id')->primary();
        // $table->string('name', 100);
        // $table->string('email', 100)->unique();
        // $table->string('phone', 15)->unique();
        // $table->date('date_of_birth');
        // $table->string('place_of_birth', 100);
        // $table->timestamp('email_verified_at')->nullable();
        // $table->string('password');
        // $table->string('province_id', 100);
        // $table->string('city_id', 100);
        // $table->string('subdistrict_id', 100);
        // $table->string('address_detail', 100);
        // $table->string('number_id', 16)->unique();
        // $table->rememberToken();
        // $table->timestamps();
        $faker = \Faker\Factory::create('id_ID');
        // seeder for admin
        $adminUser =
            User::create([
                'name' => 'Admin Ferdy',
                'email' => 'admin@admin.com',
                'phone' => $faker->unique()->phoneNumber,
                'date_of_birth' => $faker->date(),
                'place_of_birth' => $faker->city,
                'province_id' => $faker->randomNumber(),
                'city_id' => $faker->randomNumber(),
                'subdistrict_id' => $faker->randomNumber(),
                'address_detail' => $faker->address,
                'number_id' => $faker->randomNumber(),
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
                    'phone' => $faker->unique()->phoneNumber,
                    'date_of_birth' => $faker->date(),
                    'place_of_birth' => $faker->city,
                    'province_id' => $faker->randomNumber(),
                    'city_id' => $faker->randomNumber(),
                    'subdistrict_id' => $faker->randomNumber(),
                    'address_detail' => $faker->address,
                    'number_id' => $faker->randomNumber(),
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
                    'phone' => $faker->unique()->phoneNumber,
                    'date_of_birth' => $faker->date(),
                    'place_of_birth' => $faker->city,
                    'province_id' => $faker->randomNumber(),
                    'city_id' => $faker->randomNumber(),
                    'subdistrict_id' => $faker->randomNumber(),
                    'address_detail' => $faker->address,
                    'number_id' => $faker->randomNumber(),
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                ]);
            // asign role
            $userRegular->assignRole($regularMemberRole);
        }
    }
}
