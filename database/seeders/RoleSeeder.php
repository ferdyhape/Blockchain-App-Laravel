<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_data = [
            'Admin', 'Shareholder', 'Owner'
        ];
        foreach ($role_data as $role) {
            \App\Models\Role::create([
                'name' => $role,
                'level' => $role === 'Admin' ? 1 : 2,
            ]);
        }
    }
}
