<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewSubCategoryProjectSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nameDataWithKeyNameForCategory = [
            'Proses Approval Komitee' => [
                'rejected_by_committee'
            ],
        ];

        foreach ($nameDataWithKeyNameForCategory as $categoryName => $nameData) {
            foreach ($nameData as $name) {
                \App\Models\SubCategoryProjectSubmission::create([
                    'name' => $name,
                    'category_project_submission_status_id' => \App\Models\CategoryProjectSubmissionStatus::where('name', $categoryName)->first()->id
                ]);
            }
        }
    }
}
