<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return $this->superAdminDashboard();
        }

        return $this->storeDashboard();
    }

    private function superAdminDashboard()
    {
        $totalStores = \App\Models\Store::count();
        $activeStores = \App\Models\Store::where('is_active', true)->count();
        $suspendedStores = \App\Models\Store::where('is_active', false)->count();
        $overdueStores = \App\Models\Store::where('payment_status', 'overdue')->count();

        $recentStores = \App\Models\Store::with('owner')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.super-admin', compact(
            'totalStores',
            'activeStores', 
            'suspendedStores',
            'overdueStores',
            'recentStores'
        ));
    }

    private function storeDashboard()
    {
        $user = Auth::user();
        $storeId = $user->store_id;

        // Today's stats
        $todayStart = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();

        $todaySales = Sale::where('store_id', $storeId)
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('status', 'completed')
            ->sum('total_amount');

        $todayTransactions = Sale::where('store_id', $storeId)
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('status', 'completed')
            ->count();

        // Month's stats
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $monthSales = Sale::where('store_id', $storeId)
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->where('status', 'completed')
            ->sum('total_amount');

        // General stats
        $totalProducts = Product::where('store_id', $storeId)->count();
        $lowStockProducts = Product::where('store_id', $storeId)
            ->whereRaw('stock_quantity <= min_stock_level')
            ->count();
        $totalCustomers = Customer::where('store_id', $storeId)->count();

        // Recent sales
        $recentSales = Sale::where('store_id', $storeId)
            ->with(['customer', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Sales chart data (last 7 days)
        $salesChartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayStart = $date->copy()->startOfDay();
            $dayEnd = $date->copy()->endOfDay();
            
            $dailySales = Sale::where('store_id', $storeId)
                ->whereBetween('created_at', [$dayStart, $dayEnd])
                ->where('status', 'completed')
                ->sum('total_amount');
            
            $salesChartData[] = [
                'date' => $date->format('M d'),
                'sales' => $dailySales
            ];
        }

        return view('dashboard.store', compact(
            'todaySales',
            'todayTransactions',
            'monthSales',
            'totalProducts',
            'lowStockProducts',
            'totalCustomers',
            'recentSales',
            'salesChartData'
        ));
    }
}
