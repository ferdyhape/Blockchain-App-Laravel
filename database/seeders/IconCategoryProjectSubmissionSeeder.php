<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IconCategoryProjectSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $iconDataWithKeyNameForCategory = [
            'Proposal Project Terkirim' => 'fa-paper-plane',
            'Peninjauan Proposal' => 'fa-eye',
            'Proses Approval Komitee' => 'fa-check',
            'Proses Tanda Tangan Kontrak' => 'fa-signature',
            'Proses Penggalangan Dana' => 'fa-hand-holding-usd',
            'Proses Penjalanan Projek' => 'fa-running',
            'Selesai' => 'fa-check-circle',
            'Ditolak' => 'fa-circle-xmark',
            'Dibatalkan' => 'fa-times-circle'
        ];

        foreach ($iconDataWithKeyNameForCategory as $categoryName => $icon) {
            \App\Models\CategoryProjectSubmissionStatus::create([
                'name' => $categoryName,
                'icon' => $icon
            ]);
        }
    }
}
