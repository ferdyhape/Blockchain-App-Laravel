<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProjectSubmissionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Proses Approval Komitee',
            'Disetujui Komitee',
            'Proses Tanda Tangan Kontrak',
            'Proses Penggalangan Dana',
            'Dibatalkan'
        ];

        foreach ($data as $item) {
            \App\Models\CategoryProjectSubmissionStatus::create([
                'name' => $item,
            ]);
        }
    }
}
