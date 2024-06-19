<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProgressStatusOfProjectSubmission;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgressStatusOfProjectSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // add seeder for progress status of project submission using create method from Eloquent, for 5 random projects
        $projects = Project::inRandomOrder()->limit(5)->get();
        foreach ($projects as $project) {
            $categoryStatus = $project->categoryProjectSubmissionStatus()->inRandomOrder()->first();
            $randomSubCategory = $categoryStatus->subCategoryProjectSubmissions()->inRandomOrder()->first();
            ProgressStatusOfProjectSubmission::create([
                'project_id' => $project->id,
                'category_project_submission_status_id' => $categoryStatus->id,
                'sub_category_project_submission_id' => $randomSubCategory->id,
                'revision_note' => $randomSubCategory->name === 'need_revision' ? null : $faker->sentence(),
            ]);
        }
    }
}
