<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Campaign extends Model
{
    use HasFactory,
        HasUuids;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function booted()
    {
        static::creating(function ($campaign) {
            // Ambil kategori status pengajuan berdasarkan nama
            $categoryStatus = CategoryProjectSubmissionStatus::where('name', 'Proses Tanda Tangan Kontrak')->first();
            $relatedProject = Project::find($campaign->project_id);
            // Jika tidak ada kategori status atau kategorinya tidak sama dengan 'Proses Penggalangan Dana', maka batalkan pembuatan entitas
            if (!$categoryStatus || $relatedProject->category_project_submission_status_id !== $categoryStatus->id) {
                return false;
            }
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
