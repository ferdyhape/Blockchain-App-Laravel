<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AcceptContractRequest;
use App\Http\Requests\Admin\AddRevisionProjectRequest;
use App\Http\Requests\Admin\ApproveComitteeRequest;
use App\Http\Requests\Admin\RejectComitteeRequest;
use App\Http\Requests\Admin\RejectProjectRequest;
use App\Services\CategoryProjectSubmissionStatusService;

class ProjectManagementController extends Controller
{


    public function acceptContract(string $id, AcceptContractRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            ProjectService::acceptContract($id, $validated);
            DB::commit();
            return redirect()->back()->with('success', 'Contract accepted successfully');
        } catch (\Exception $e) {
            $e->getMessage();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function rejectCommittee(string $id, RejectComitteeRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            ProjectService::rejectCommittee($id, $validated);
            DB::commit();
            return redirect()->back()->with('success', 'Committee rejected successfully');
        } catch (\Exception $e) {
            $e->getMessage();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function approveCommittee(string $id, ApproveComitteeRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);
        try {
            DB::beginTransaction();
            ProjectService::approveCommittee($id, $validated);
            DB::commit();
            return redirect()->back()->with('success', 'Committee approved successfully');
        } catch (\Exception $e) {
            $e->getMessage();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function acceptRevision(string $id)
    {
        try {
            DB::beginTransaction();
            ProjectService::acceptRevision($id);
            DB::commit();
            return redirect()->back()->with('success', 'Revision accepted successfully');
        } catch (\Exception $e) {
            $e->getMessage();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function accept(string $id)
    {
        try {
            DB::beginTransaction();
            ProjectService::accept($id);
            DB::commit();
            return redirect()->back()->with('success', 'Project accepted successfully');
        } catch (\Exception $e) {
            $e->getMessage();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function reject($id, RejectProjectRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            ProjectService::reject($id, $validated);
            DB::commit();
            return redirect()->back()->with('success', 'Project rejected successfully');
        } catch (\Exception $e) {
            $e->getMessage();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function addRevision($id, AddRevisionProjectRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            ProjectService::addRevision($id, $validated);
            DB::commit();
            return redirect()->back()->with('success', 'Revision added successfully');
        } catch (\Exception $e) {
            $e->getMessage();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return ProjectService::ajaxDatatableByAdmin();
        }

        return view('auth.admin.project_management.index');
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
        $project = ProjectService::getProjectById($id);
        $allCategoryStatus = CategoryProjectSubmissionStatusService::getAllCategory();
        DB::beginTransaction();
        ProjectService::onReview($id);
        DB::commit();
        return view('auth.admin.project_management.show', compact('project', 'allCategoryStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        //
    }
}
