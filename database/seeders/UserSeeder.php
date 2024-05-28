<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regularMemberRole = Role::where('name', 'Regular Member')->first();
        $platinumMemberRole = Role::where('name', 'Platinum Member')->first();

        $faker = Faker::create('id_ID');

        // Seeder for platinum member
        for ($i = 0; $i < 10; $i++) {
            $userPlatinum = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email(),
                'phone' => $faker->unique()->phoneNumber,
                'date_of_birth' => $faker->date(),
                'place_of_birth' => $faker->city,
                'province_id' => $faker->randomNumber(),
                'city_id' => $faker->randomNumber(),
                'subdistrict_id' => $faker->randomNumber(),
                'address_detail' => $faker->address,
                'number_id' => $faker->unique()->randomNumber(),
                'password' => Hash::make('password'),
            ]);
            // Assign role
            $userPlatinum->assignRole($platinumMemberRole);
        }

        // // Seeder for regular member
        // for ($i = 0; $i < 10; $i++) {
        //     $userRegular = User::create([
        //         'name' => $faker->name,
        //         'email' => $faker->unique()->email(),
        //         'phone' => $faker->unique()->phoneNumber,
        //         'date_of_birth' => $faker->date(),
        //         'place_of_birth' => $faker->city,
        //         'province_id' => $faker->randomNumber(),
        //         'city_id' => $faker->randomNumber(),
        //         'subdistrict_id' => $faker->randomNumber(),
        //         'address_detail' => $faker->address,
        //         'number_id' => $faker->unique()->randomNumber(),
        //         'password' => Hash::make('password'),
        //     ]);
        //     // Assign role
        //     $userRegular->assignRole($regularMemberRole);
        // }
    }
}
