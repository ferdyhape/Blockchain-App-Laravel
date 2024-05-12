<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryProjectSubmissionStatus extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'category_project_submission_status_id', 'id');
    }

    public function progressStatus()
    {
        return $this->hasMany(ProgressStatusOfProjectSubmission::class, 'category_project_submission_status_id', 'id');
    }

    public function subCategoryProjectSubmissions()
    {
        return $this->hasMany(SubCategoryProjectSubmission::class, 'category_project_submission_status_id', 'id');
    }
}
