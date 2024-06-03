<?php

namespace App\Services;

/**
 * Class MediaLibraryService.
 */
class MediaLibraryService
{
    public static function updateMedia($model, $files, $collection, $isArray = true)
    {
        $model->clearMediaCollection($collection);
        self::attachMedia($model, $files, $collection, $isArray);
    }

    public static function attachMedia($model, $files, $collection, $isArray = true)
    {
        if ($isArray) {
            foreach ($files as $file) {
                $model->addMedia($file)->toMediaCollection($collection);
            }
        } else {
            $model->addMedia($files)->toMediaCollection($collection);
        }
    }
}
