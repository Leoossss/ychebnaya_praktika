<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motorcycle;
use App\Models\Order;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Общая статистика
        $stats = [
            'total_motorcycles' => Motorcycle::count(),
            'published_motorcycles' => Motorcycle::where('is_published', true)->count(),
            'total_orders' => Order::count(),
            'new_orders' => Order::where('status', 'new')->count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total_amount'),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
            'low_stock' => Motorcycle::where('stock', '<', 3)->count(),
        ];

        // Последние заказы
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Топ мотоциклов по заказам
        $topMotorcycles = Motorcycle::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        // Заказы по статусам
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Выручка за последние 7 дней
        $revenueLast7Days = Order::where('status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'topMotorcycles',
            'ordersByStatus',
            'revenueLast7Days'
        ));
    }
}