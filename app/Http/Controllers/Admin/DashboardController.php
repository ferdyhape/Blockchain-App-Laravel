<?php

namespace App\Http\Controllers\Admin;

use APIHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $transactions = APIHelper::httpGet('getTransactions');
            // $transactionDetails = APIHelper::httpGet('getTransactionDetails');
            return DataTables::of($transactions['data'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('auth.admin.dashboard.index');
    }

    public function testPost()
    {
        $postData = [
            'transactionCode' => 'TRX-0001',
            'from' => 'Ferdy Doe',
            'fromId' => '1',
            'to' => 'John Doe',
            'toId' => '2',
            'orderType' => 'buy',
            'paymentStatus' => 'pending',
            'createdAt' => time(),
        ];
        $response = APIHelper::httpPost('addTransaction', $postData);
        return response()->json($response);
    }
}
