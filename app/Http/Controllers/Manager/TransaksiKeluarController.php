<?php

namespace App\Http\Controllers\Manager;

use App\Services\StockTransactionService;
use App\Services\StockService;
use Illuminate\Routing\Controller;

class TransaksiKeluarController extends Controller
{
    public function __construct(
        protected StockTransactionService $transactionService,
        protected StockService $stockService,
    ) {}

    public function index()
    {
        $pending  = $this->transactionService->getAllTransaksiKeluarPending();
        $allKeluar = $this->transactionService->getAllTransaksiKeluar();
        $stockMap  = $this->stockService->getStockMap();

        return view('manager.transaksi-keluar.index', compact('pending', 'allKeluar', 'stockMap'));
    }

    public function konfirmasi(int $id)
    {
        try {
            $this->transactionService->konfirmasiKeluar($id);
            return redirect()->route('manager.transaksi-keluar.index')
                ->with('success', 'Transaksi keluar dikonfirmasi. Stok telah berkurang.');
        } catch (\Exception $e) {
            return redirect()->route('manager.transaksi-keluar.index')
                ->with('error', $e->getMessage());
        }
    }

    public function tolak(int $id)
    {
        try {
            $this->transactionService->tolakKeluar($id);
            return redirect()->route('manager.transaksi-keluar.index')
                ->with('success', 'Transaksi keluar berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->route('manager.transaksi-keluar.index')
                ->with('error', $e->getMessage());
        }
    }
}