<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategoryProjectSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nameDataWithKeyNameForCategory = [
            'Proposal Project Terkirim' => [
                'submitted',
            ],
            'Peninjauan Proposal' => [
                'on_review',
                'need_revision',
                'revised',
                'revision_approved',
                'review_approved'
            ],
            'Proses Approval Komitee' => [
                'on_approving_committee',
                'approved_by_committee',
                'rejected_by_committee'
            ],
            'Proses Tanda Tangan Kontrak' => [
                'on_contract_signing',
                'contract_signed',
                'contract_signed_accepted',
                'contract_signed_need_revision'
            ],
            'Proses Penggalangan Dana' => [
                'on_fundraising',
            ],
            'Proses Penjalanan Projek' => [
                'on_going',
            ],
            'Selesai' => [
                'closed'
            ],
            'Ditolak' => [
                'rejected'
            ]
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
