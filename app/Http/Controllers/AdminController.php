<?php

// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Admin-Dashboard oder Startseite
        return view('admin.adminDashboard');
    }

    // Weitere Admin-Methoden
}
