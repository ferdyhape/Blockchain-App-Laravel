<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\CategoryProjectSubmissionStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Services\SubCategoryProjectSubmissionService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->category_project_submission_status_id = CategoryProjectSubmissionStatus::where('name', 'Proposal Project Terkirim')->first()->id;
        });
    }

    public function isSubOnReview()
    {
        $subCategoryOnReview = SubCategoryProjectSubmissionService::getSubCategoryByName('on_review');
        return $this->progressStatusOfProjectSubmission()->where('sub_category_project_submission_id', $subCategoryOnReview->id)->exists();
    }

    public function isOnReview()
    {
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatus::where('name', 'Peninjauan Proposal')->first();
        return $this->category_project_submission_status_id === $categoryProjectSubmissionStatus->id;
    }

    public function isOnApproveCommittee()
    {
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatus::where('name', 'Proses Approval Komitee')->first();
        return $this->category_project_submission_status_id === $categoryProjectSubmissionStatus->id;
    }

    public function isSigningContract()
    {
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatus::where('name', 'Proses Tanda Tangan Kontrak')->first();
        return $this->category_project_submission_status_id === $categoryProjectSubmissionStatus->id;
    }

    public function isRejected()
    {
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatus::where('name', 'Ditolak')->first();
        return $this->category_project_submission_status_id === $categoryProjectSubmissionStatus->id;
    }

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

    public function progressStatusOfProjectSubmission()
    {
        return $this->hasMany(ProgressStatusOfProjectSubmission::class, 'project_id', 'id');
    }

    // public function publishedProject()
    // {
    //     return $this->hasOne(PublishedProject::class, 'project_id', 'id');
    // }

    public function campaign()
    {
        return $this->hasOne(Campaign::class, 'project_id', 'id');
    }
}
