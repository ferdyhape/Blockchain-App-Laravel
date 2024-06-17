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
    public static function buildDatatable($query, $actions = null)
    {
        if ($actions) {
            return datatables($query)
                ->addIndexColumn()
                ->addColumn('action', $actions)
                ->make(true);
        }
        return
            datatables($query)
            ->addIndexColumn()
            ->make(true);
    }
}
