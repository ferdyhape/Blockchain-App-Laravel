<?php

namespace App\Services;

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
    public static function buildDatatable($query, $actions)
    {
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', $actions)
            ->make(true);
    }
}
