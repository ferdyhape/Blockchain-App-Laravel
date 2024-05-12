<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function progressStatus()
    {
        return $this->hasMany(ProgressStatusOfProjectSubmission::class, 'project_id', 'id');
    }

    public function categoryProjectSubmissionStatus()
    {
        return $this->belongsTo(CategoryProjectSubmissionStatus::class, 'category_project_submission_status_id', 'id');
    }
}
