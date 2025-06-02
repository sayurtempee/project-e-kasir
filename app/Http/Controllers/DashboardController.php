<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Member;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $title = "Dashboard";

        $productCount = Product::count();
        $memberCount = Member::count();
        $adminCount = User::where('role', 'admin')->count();
        $cashierCount = User::where('role', 'kasir')->count();
        $totalMoney = Transaction::sum('total_price');
        $categoryCount = Category::count();

        $allowedRanges = ['7', '30', 'all'];
        $range = $request->get('range', '7');

        if (!in_array($range, $allowedRanges, true)) {
            $range = '7';
        }

        $query = Transaction::query();

        if ($range !== 'all') {
            $days = (int)$range;
            $query->where('created_at', '>=', Carbon::now()->subDays($days));
        }

        $salesData = $query->selectRaw('DATE(created_at) as date, SUM(total_price) as total_sales')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Set locale bahasa Indonesia
        Carbon::setLocale('id');

        $dates = $salesData->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->translatedFormat('d M');
        });

        $sales = $salesData->pluck('total_sales');

        return view('dashboard', compact(
            'productCount',
            'memberCount',
            'adminCount',
            'totalMoney',
            'title',
            'dates',
            'sales',
            'range',
            'categoryCount',
            'cashierCount'
        ));
    }
}
