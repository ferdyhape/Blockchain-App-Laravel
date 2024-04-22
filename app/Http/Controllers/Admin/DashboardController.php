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
}
