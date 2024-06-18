<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;

/**
 * Class DatatableService.
 */
class DatatableService
{
    /**
     * @param $model
     * @param $columns
     * @param $actions
     *
     * @return mixed
     */
    public static function buildDatatable($query, $actions = null)
    {
        $datatable = DataTables::of($query)->addIndexColumn();

        if ($actions) {
            $datatable->addColumn('action', function ($row) use ($actions) {
                $row = (object) $row;
                return view($actions, ['model' => $row])->render();
            });
        }

        return $datatable->make(true);
    }
}
