<?php

namespace App\Services;

use App\Models\Project;

/**
 * Class ProgressStatusOfProjectSubmissionService.
 */
class ProgressStatusOfProjectSubmissionService
{
    public static function getProgressStatusByProjectId($projectId)
    {
        return Project::find($projectId)->progressStatusOfProjectSubmission()->orderBy('created_at')->get();
    }
}
