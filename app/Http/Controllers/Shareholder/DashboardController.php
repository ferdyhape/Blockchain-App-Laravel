<?php

namespace App\Http\Controllers\Shareholder;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('auth.shareholder.dashboard.index', compact('products'));
    }
}
