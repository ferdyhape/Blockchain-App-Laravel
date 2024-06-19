<?php

namespace App\Services;

use App\Models\User;

/**
 * Class UserService.
 */
class UserService
{

    public static function getUserById($id)
    {
        return User::find($id);
    }
}
