<?php

namespace Database\Seeders;

use App\Models\ProgressStatusOfProjectSubmission;
use App\Models\PublishedProject;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $seedOnApprove = false;
        $hasOneFundraising = false;

        foreach (range(1, 20) as $index) {
            $randomUser = DB::table('users')->inRandomOrder()->first();
            $randomProjectCategory = DB::table('project_categories')->inRandomOrder()->first();
            $randomStatus = DB::table('category_project_submission_statuses')->where('name', 'Proposal Project Terkirim')->first();
            $approvedStatus = DB::table('category_project_submission_statuses')->where('name', 'Proses Penggalangan Dana')->first();

            // Cek apakah sudah ada proyek dengan status "Proses Penggalangan Dana"
            if (!$hasOneFundraising && !$seedOnApprove) {
                $statusId = $approvedStatus->id;
                $hasOneFundraising = true;
            } else {
                $statusId = $randomStatus->id;
            }

            $projectId = Str::uuid();
            DB::table('projects')->insert([
                'id' => $projectId,
                'user_id' => $randomUser->id,
                'project_category_id' => $randomProjectCategory->id,
                'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'nominal_required' => $faker->randomNumber($nbDigits = 7),
                'description_of_use_of_funds' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'collateral_assets' => $faker->sentence($nbWords = 3, $variableNbWords = true),
                'collateral_value' => $faker->randomNumber($nbDigits = 7),
                'business_location_province_id' => $faker->stateAbbr,
                'business_location_city_id' => $faker->city,
                'business_location_subdistrict_id' => $faker->citySuffix,
                'details_of_business_location' => $faker->address,
                'income_per_month' => $faker->randomNumber($nbDigits = 7),
                'projected_revenue_per_month' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'expenses_per_month' => $faker->randomNumber($nbDigits = 7),
                'projected_monthly_expenses' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'income_statement_upload_every' => $faker->randomElement([1, 3, 6]),
                'description_of_profit_sharing' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'category_project_submission_status_id' => $statusId,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);

            PublishedProject::create([
                'id' => Str::uuid(),
                'project_id' => $projectId,
                'approved_amount' => $faker->randomNumber($nbDigits = 7),
                'offered_token_amount' => $faker->randomNumber($nbDigits = 7),
                'price_per_unit' => $faker->randomNumber($nbDigits = 7),
                'minimum_purchase' => $faker->randomNumber($nbDigits = 7),
                'maximum_purchase' => $faker->randomNumber($nbDigits = 7),
            ]);

            $seedOnApprove = true;
        }
    }
}
