<?php

// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\GuestOrder;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function index()
    {
        $ordersData = $this->currentOrders();
        $currentMonthName = Carbon::now()->format('F');

        $todayGuestOrdersCount = DB::table('guest_orders')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $todayOrdersCount = DB::table('orders')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Admin-Dashboard oder Startseite
        return view('admin.adminDashboard', [
            'todayGuestOrdersCount' => $todayGuestOrdersCount,
            'todayOrdersCount' => $todayOrdersCount,
            'orderCounts' => $ordersData['orderCounts'],
            'daysInMonth' => $ordersData['daysInMonth'],
            'currentMonthName' => $currentMonthName
        ]);
    }

    public function manageOrders()
    {

        return view('admin.orders.index');
    }

    public function manageProducts()
    {
        $products = Product::all();

        return view('admin.products.index', compact('products'));
    }

    public function currentOrders()
    {
        // Ermittelt den aktuellen Monat und Jahr
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Abrufen der Bestellungen pro Tag im aktuellen Monat für GuestOrder
        $guestOrdersPerDay = GuestOrder::selectRaw('DAY(created_at) as day, COUNT(*) as count')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('day')
            ->get()
            ->keyBy('day'); // Gruppiere nach Tag für einfacheren Zugriff

        // Abrufen der Bestellungen pro Tag im aktuellen Monat für Order
        $ordersPerDay = Order::selectRaw('DAY(created_at) as day, COUNT(*) as count')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('day')
            ->get()
            ->keyBy('day'); // Gruppiere nach Tag für einfacheren Zugriff

        // Konvertiere Daten für das Chart.js-Format
        $daysInMonth = Carbon::now()->daysInMonth;
        $orderCounts = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            // Addiere die Bestellungen von GuestOrder und Order für jeden Tag
            $guestOrderCount = $guestOrdersPerDay->get($day) ? $guestOrdersPerDay->get($day)->count : 0;
            $orderCount = $ordersPerDay->get($day) ? $ordersPerDay->get($day)->count : 0;

            // Summe der Bestellungen (GuestOrder + Order) für diesen Tag
            $orderCounts[$day] = $guestOrderCount + $orderCount;
        }

        return [
            'orderCounts' => $orderCounts,
            'daysInMonth' => $daysInMonth
        ];
    }
}
