<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PublishedProject extends Model
{
    use HasFactory,
        HasUuids;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function booted()
    {
        static::creating(function ($publishedProject) {
            // Ambil kategori status pengajuan berdasarkan nama
            $categoryStatus = CategoryProjectSubmissionStatus::where('name', 'Proses Penggalangan Dana')->first();
            $relatedProject = Project::find($publishedProject->project_id);
            // Jika tidak ada kategori status atau kategorinya tidak sama dengan 'Proses Penggalangan Dana', maka batalkan pembuatan entitas
            if (!$categoryStatus || $relatedProject->category_project_submission_status_id !== $categoryStatus->id) {
                return false;
            }
        });
    }

    /**
     * Get the project associated with the published project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
