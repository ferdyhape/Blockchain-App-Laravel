<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressStatusOfProjectSubmission extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function categoryProjectSubmissionStatus()
    {
        return $this->belongsTo(CategoryProjectSubmissionStatus::class, 'category_project_submission_status_id', 'id');
    }

    public function subCategoryProjectSubmission()
    {
        return $this->belongsTo(SubCategoryProjectSubmission::class, 'sub_category_project_submission_id', 'id');
    }
}
