<?php

namespace App\Services;

use App\Models\CategoryProjectSubmissionStatus;

/**
 * Class CategoryProjectSubmissionStatusService.
 */
class CategoryProjectSubmissionStatusService
{

    public static function getAllCategory()
    {
        return CategoryProjectSubmissionStatus::all();
    }

    public static function getCategoryByName($name)
    {
        return CategoryProjectSubmissionStatus::where('name', $name)->first();
    }
}
