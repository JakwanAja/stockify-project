<?php

namespace App\Http\Controllers\Admin;

use App\Models\StockTransaction;
use App\Models\User;
use App\Models\Category;
use App\Services\StockService;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __construct(
        protected StockService $stockService
    ) {}

    public function index()
    {
        // Summary stok dari StockService
        $summary = $this->stockService->getDashboardSummary();

        // Total pengguna
        $totalUsers = User::count();

        // Transaksi bulan ini
        $totalTransaksiMasuk = StockTransaction::where('type', 'Masuk')
                                ->whereMonth('date', now()->month)
                                ->whereYear('date', now()->year)
                                ->count();

        $totalTransaksiKeluar = StockTransaction::where('type', 'Keluar')
                                ->whereMonth('date', now()->month)
                                ->whereYear('date', now()->year)
                                ->count();

        // Grafik — jumlah produk per kategori
        $stokPerKategori = Category::withCount('products')
                            ->orderBy('products_count', 'desc')
                            ->take(8)
                            ->get();

        // Stok menipis (menggunakan StockService)
        $lowStockProducts = $this->stockService->getLowStockProducts()->take(5);

        // Aktivitas terbaru
        $recentTransactions = StockTransaction::with(['product', 'user'])
                                ->latest('created_at')
                                ->take(8)
                                ->get();

        return view('admin.dashboard', compact(
            'summary',
            'totalUsers',
            'totalTransaksiMasuk',
            'totalTransaksiKeluar',
            'stokPerKategori',
            'lowStockProducts',
            'recentTransactions',
        ));
    }
}