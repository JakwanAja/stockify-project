<?php

namespace App\Http\Controllers\Manager;

use App\Services\StockService;
use App\Services\StockTransactionService;
use App\Models\StockTransaction;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __construct(
        protected StockService $stockService,
        protected StockTransactionService $transactionService,
    ) {}

    public function index()
    {
        // Stat cards
        $totalPending       = StockTransaction::where('status', 'Pending')->count();
        $masukHariIni       = StockTransaction::where('type', 'Masuk')
                                ->whereDate('created_at', today())
                                ->count();
        $keluarHariIni      = StockTransaction::where('type', 'Keluar')
                                ->whereDate('created_at', today())
                                ->count();

        // Stok menipis
        $lowStockProducts   = $this->stockService->getLowStockProducts()->take(8);

        // Transaksi pending butuh aksi
        $pendingMasuk       = $this->transactionService->getAllTransaksiMasukPending()->take(5);
        $pendingKeluar      = $this->transactionService->getAllTransaksiKeluarPending()->take(5);

        return view('manager.dashboard', compact(
            'totalPending',
            'masukHariIni',
            'keluarHariIni',
            'lowStockProducts',
            'pendingMasuk',
            'pendingKeluar',
        ));
    }
}