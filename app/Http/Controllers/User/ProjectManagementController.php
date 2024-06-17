<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\ProjectCategory;
use App\Services\ProjectService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\PayForSaleTokenRequest;
use App\Services\TransactionService;
use App\Services\PaymentMethodService;
use App\Services\ProjectCategoryService;
use App\Http\Requests\User\StoreProjectRequest;
use App\Http\Requests\User\ReviseProjectRequest;
use App\Http\Requests\User\SignedContractRequest;
use App\Services\CampaignService;
use App\Services\CategoryProjectSubmissionStatusService;

class ProjectManagementController extends Controller
{

    public function payForSaleToken($transactionCode, PayForSaleTokenRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            TransactionService::payForSaleToken($transactionCode, $validated['payment_method'], $validated['payment_method'] === 'transfer' ? $request->file('payment_proof') : null);
            DB::commit();

            return redirect()->back()->with('success', 'Upload payment proof successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function showTransaction(string $transactionCode)
    {
        // dd($transactionCode);
        $transaction = TransactionService::getTransactionByCode($transactionCode);
        $paymentMethodDetail = PaymentMethodService::getPaymentMethodDetailById($transaction->payment_method_detail_id);
        $walletBalance = CampaignService::getCampaignWalletBalanceFromTransaction($transactionCode);
        return view('auth.user.project_management.showTransaction', compact('transaction', 'walletBalance', 'paymentMethodDetail'));
    }

    public function checkTransaction(string $projectId)
    {
        $project = ProjectService::getProjectById($projectId);

        if (request()->ajax()) {
            $transactions = TransactionService::ajaxDatatableTransactionInProjectManagementByUser($project->campaign->id);
            return $transactions;
        }

        $transactions = TransactionService::getTransactionByCampaignId($project->campaign->id);
        // dd($transactions->toArray());

        return view('auth.user.project_management.checkTransaction', compact('project', 'transactions'));
    }

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
