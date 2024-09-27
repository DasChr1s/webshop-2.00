<?php

// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $todayOrdersCount = DB::table('guest_orders')
            ->whereDate('created_at', Carbon::today())
            ->count();
        // Admin-Dashboard oder Startseite
        return view('admin.adminDashboard', compact('todayOrdersCount'));
    }

    public function manageOrders()
    {
       
        return view('admin.orders.index');
    }

    public function manageProducts()
    {
       
        return view('admin.products.index');
    }
}
