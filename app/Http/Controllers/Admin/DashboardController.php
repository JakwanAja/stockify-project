<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Stat Cards
        $totalProducts     = Product::count();
        $totalUsers        = User::count();
        $totalTransaksiMasuk  = StockTransaction::where('type', 'Masuk')
                                ->whereMonth('date', now()->month)
                                ->whereYear('date', now()->year)
                                ->count();
        $totalTransaksiKeluar = StockTransaction::where('type', 'Keluar')
                                ->whereMonth('date', now()->month)
                                ->whereYear('date', now()->year)
                                ->count();

        
        $stokPerKategori = Category::withCount('products')
                            ->orderBy('products_count', 'desc')
                            ->take(8)
                            ->get();

        // Aktivitas terbaru — 8 transaksi terakhir
        $recentTransactions = StockTransaction::with(['product', 'user'])
                                ->latest('created_at')
                                ->take(8)
                                ->get();

        // Stok menipis — produk yang stoknya di bawah minimum
        $lowStockProducts = Product::with('category')
                            ->whereRaw('minimum_stock > 0')
                            ->orderBy('minimum_stock', 'desc')
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalUsers',
            'totalTransaksiMasuk',
            'totalTransaksiKeluar',
            'stokPerKategori',
            'recentTransactions',
            'lowStockProducts',
        ));
    }
}