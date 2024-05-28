<?php

namespace App\Services;

use App\Models\User;

/**
 * Class AdminUserManagementService.
 */
class UserManagementService
{
    public static function ajaxDatatableByAdmin()
    {
        $query = User::with(['roles', 'media'])->get();
        $query->each(function ($query) {
            $query->supporting_documents = $query->getMedia('supporting_documents');
        });

        return DatatableService::buildDatatable(
            $query,
            'auth.admin.user_management.action'
        );
    }

    public static function getUserData(string $id)
    {
        return User::findOrFail($id);
    }
}
