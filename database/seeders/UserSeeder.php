<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // seeder for admin
        \App\Models\User::create([
            'name' => 'Admin Ferdy',
            'email' => 'admin@admin.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role_id' => \App\Models\Role::where('name', 'Admin')->first()->id,
        ]);

        // seeder for user non admin
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 30; $i++) {
            \App\Models\User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role_id' => \App\Models\Role::whereNot('name', 'Admin')->first()->id,
                'wallet_account_address' => '0x' . $faker->uuid,
            ]);
        }
    }
}
