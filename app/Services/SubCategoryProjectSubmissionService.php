<?php

namespace App\Services;

use App\Models\SubCategoryProjectSubmission;

/**
 * Class SubCategoryProjectSubmissionService.
 */
class SubCategoryProjectSubmissionService
{
    public static function getSubCategoryByName($name)
    {
        return SubCategoryProjectSubmission::where('name', $name)->first();
    }
}
