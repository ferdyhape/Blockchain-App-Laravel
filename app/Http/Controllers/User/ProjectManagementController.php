<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\ProjectCategory;
use App\Services\ProjectService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ReviseProjectRequest;
use App\Http\Requests\User\SignedContractRequest;
use App\Services\ProjectCategoryService;
use App\Http\Requests\User\StoreProjectRequest;
use App\Services\CategoryProjectSubmissionStatusService;
use App\Services\ProgressStatusOfProjectSubmissionService;

class ProjectManagementController extends Controller
{

    public function postUploadSignedContract(string $id, SignedContractRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            ProjectService::uploadSignedContract($id, $validated['signed_contract']);
            DB::commit();
            return redirect()->route('dashboard.user.project-management.show', $id)->with('success', 'Contract uploaded successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function uploadSignedContract(string $id)
    {
        $project = ProjectService::getProjectById($id);
        return view('auth.user.project_management.upload_signed_contract', compact('project'));
    }

    public function postReviseProject(ReviseProjectRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            ProjectService::revise(
                $id,
                $validated,
                $request->hasFile('supporting_documents') ? $request->file('supporting_documents') : null,
                $request->hasFile('product_catalog') ? $request->file('product_catalog') : null
            );
            DB::commit();
            return redirect()->route('dashboard.user.project-management.show', $id)->with('success', 'Revision sent successfully');
        } catch (\Exception $e) {
            $e->getMessage();
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }


    public function reviseProject(string $id)
    {
        $project = ProjectService::getProjectById($id);
        $projectCategories = ProjectCategoryService::getAllProjectCategories();
        return view('auth.user.project_management.revise', compact('project', 'projectCategories'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = ProjectService::getProjectByUserId(auth()->user()->id);
        return view('auth.user.project_management.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projectCategories = ProjectCategoryService::getAllProjectCategories();
        return view('auth.user.project_management.create', compact('projectCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            ProjectService::storeProject(
                $validated,
                $request->hasFile('supporting_documents') ? $request->file('supporting_documents') : null,
                $request->hasFile('product_catalog') ? $request->file('product_catalog') : null
            );
            DB::commit();
            return redirect()->route('dashboard.user.project-management.index')->with('success', 'Project sent successfully');
        } catch (\Exception $e) {
            $e->getMessage();
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = ProjectService::getProjectById($id);
        $allCategoryStatus = CategoryProjectSubmissionStatusService::getAllCategory();
        return view('auth.user.project_management.show', compact('project', 'allCategoryStatus'));
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
