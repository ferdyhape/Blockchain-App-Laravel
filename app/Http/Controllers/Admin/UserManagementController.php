<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\JsonService;
use App\Services\DatatableService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Services\UserManagementService;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return UserManagementService::ajaxDatatableByAdmin();
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
        try {
            $data = UserManagementService::getUserData($id);
            return JsonService::editData($data);
        } catch (\Exception $e) {
            return JsonService::response(['message' => 'Data not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $user = UserManagementService::getUserData($id);
            $user->update($request->all());
            return JsonService::response(['message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            return JsonService::response(['message' => 'Data failed to update'], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = UserManagementService::getUserData($id);
            $data->delete();
            return JsonService::response(['message' => 'Data deleted successfully']);
        } catch (\Exception $e) {
            return JsonService::response(['message' => 'Data failed to delete'], 500);
        }
    }
}
