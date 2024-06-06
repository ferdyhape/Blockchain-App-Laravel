<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Services\CampaignService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\BuyProjectRequest;
use App\Http\Requests\User\PreviewTransactionRequest;
use App\Services\TransactionService;
use App\Services\PaymentMethodService;

class AvailableProjectController extends Controller
{

    //  postBuyProject
    public function postBuyProject(BuyProjectRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $transaction = TransactionService::storeTransaction($validated);
            DB::commit();
            return response()->json(
                [
                    'redirect' => route('dashboard.user.transaction.show', $transaction->transaction_code),
                    'message' => 'Transaction success'
                ],
                200
            );
        } catch (\Exception $e) {
            $e->getMessage();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    // previewTransaction
    public function previewTransaction(PreviewTransactionRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            $project = ProjectService::getProjectById($id);

            if (!TransactionService::checkIfMaximumPurchased($project->campaign->id, $validated['quantity'])) {
                return redirect()->back()->with('error', 'Maximum purchase exceeded');
            }

            $totalPrice = $project->campaign->price_per_unit * $validated['quantity'];
            $paymentMethods = PaymentMethodService::getPaymentMethodForBuyToken();

            return view('auth.user.available_project.preview_transaction', [
                'project' => $project,
                'quantityBuy' => $validated['quantity'],
                'totalPrice' => $totalPrice,
                'paymentMethods' => $paymentMethods
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }


    // buyProject
    public function buyProject(string $id)
    {
        $project = ProjectService::getProjectById($id);
        return view('auth.user.available_project.buy', compact('project'));
    }

    public function index()
    {
        $campaigns = CampaignService::getCampaigns();
        return view('auth.user.available_project.index', compact('campaigns'));
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
        return view('auth.user.available_project.show', compact('project'));
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
