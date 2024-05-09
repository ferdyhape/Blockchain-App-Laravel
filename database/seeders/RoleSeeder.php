<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_data = [
            'Admin', 'Platinum Member', 'Regular Member'
        ];
        foreach ($role_data as $role) {
            Role::create([
                'name' => $role,
            ]);
        }
    }
}
