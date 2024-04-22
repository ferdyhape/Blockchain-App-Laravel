<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        // seeder for admin
        \App\Models\User::create([
            'name' => 'Admin Ferdy',
            'email' => 'admin@admin.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role_id' => \App\Models\Role::where('name', 'Admin')->first()->id,
        ]);

        // seeder for shareholder
        for ($i = 0; $i < 10; $i++) {
            \App\Models\User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email(),
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role_id' => \App\Models\Role::where('name', 'Shareholder')->first()->id,
                'wallet_account_address' => '0x' . $faker->uuid,
            ]);
        }

        // seeder for owner
        for ($i = 0; $i < 10; $i++) {
            \App\Models\User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email(),
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role_id' => \App\Models\Role::where('name', 'Owner')->first()->id,
                'wallet_account_address' => '0x' . $faker->uuid,
            ]);
        }
    }
}
