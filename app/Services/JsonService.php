<?php

namespace App\Services;

/**
 * Class JsonService.
 */
class JsonService
{
    public static function response($data, $status = 200)
    {
        return response()->json($data, $status);
    }

    public static function editData($data)
    {
        return self::response($data);
    }
}
