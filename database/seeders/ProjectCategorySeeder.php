<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectCategoriesData = [
            'UMKM',
            'Startup',
        ];

        foreach ($projectCategoriesData as $projectCategoryData) {
            \App\Models\ProjectCategory::create([
                'name' => $projectCategoryData,
            ]);
        }
    }
}
