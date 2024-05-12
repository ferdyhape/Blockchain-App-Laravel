<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\JsonService;
use App\Services\DatatableService;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = User::with('roles')->get();

            return DatatableService::buildDatatable(
                $query,
                'auth.admin.user_management.action'
            );
        }

        return view('auth.admin.user_management.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::findOrFail($id);
        return JsonService::editData($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::findOrFail($id);
        try {
            $data->delete();
            return JsonService::response(['message' => 'Data deleted successfully']);
        } catch (\Exception $e) {
            return JsonService::response(['message' => 'Data failed to delete'], 500);
        }
    }
}
