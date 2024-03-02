<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userWithoutAdmin = \App\Models\User::whereNot('role_id', \App\Models\Role::where('name', 'Admin')->first()->id)->get();
        $countOfUserWithoutAdmin = $userWithoutAdmin->count();

        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < $countOfUserWithoutAdmin / 2; $i++) {
            \App\Models\Company::create([
                'user_id' => $userWithoutAdmin[$i]->id,
                'name' => $faker->company,
                'description' => $faker->text,
                'address' => $faker->address,
                'logo' => $faker->imageUrl(),
                'city' => $faker->city,
                'country' => $faker->country,
                'phone' => $faker->phoneNumber,
                'employee_count' => $faker->numberBetween(10, 1000),
                'established_year' => $faker->year,
            ]);
        }
    }
}
