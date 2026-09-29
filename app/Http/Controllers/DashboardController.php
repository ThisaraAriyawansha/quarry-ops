<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $todaySales = Sale::whereDate('created_at', today())->sum('total_amount');
        $totalProducts = Product::where('is_active', true)->count();
        $totalEmployees = Employee::where('is_active', true)->count();
        $recentSales = Sale::with('customer')->latest()->take(5)->get();

        return view('dashboard', compact('todaySales', 'totalProducts', 'totalEmployees', 'recentSales'));
    }
}
