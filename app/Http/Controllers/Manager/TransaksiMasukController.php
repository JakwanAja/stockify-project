<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Routing\Controller;
use App\Services\StockTransactionService;
use App\Services\StockService;
use Illuminate\Http\Request;

class TransaksiMasukController extends Controller
{
    public function __construct(
        protected StockTransactionService $transactionService,
        protected StockService $stockService,
    ) {}

    public function index()
    {
        $pending    = $this->transactionService->getAllTransaksiMasukPending();
        $allMasuk   = $this->transactionService->getAllTransaksiMasuk();
        $stockMap   = $this->stockService->getStockMap();

        return view('manager.transaksi-masuk.index', compact('pending', 'allMasuk', 'stockMap'));
    }

    public function konfirmasi(int $id)
    {
        try {
            $this->transactionService->konfirmasiMasuk($id);
            return redirect()->route('manager.transaksi-masuk.index')
                ->with('success', 'Transaksi masuk berhasil dikonfirmasi. Stok telah diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('manager.transaksi-masuk.index')
                ->with('error', $e->getMessage());
        }
    }

    public function tolak(int $id)
    {
        try {
            $this->transactionService->tolakMasuk($id);
            return redirect()->route('manager.transaksi-masuk.index')
                ->with('success', 'Transaksi masuk berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->route('manager.transaksi-masuk.index')
                ->with('error', $e->getMessage());
        }
    }
}