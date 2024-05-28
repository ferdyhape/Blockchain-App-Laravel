<?php

namespace App\Services;

use App\Models\ProjectCategory;

/**
 * Class ProjectCategoryService.
 */
class ProjectCategoryService
{
    public static function getAllProjectCategories()
    {
        return ProjectCategory::all();
    }
}
