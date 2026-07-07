<?php

namespace App\Http\Controllers\Admin;

use App\Services\StockTransactionService;
use App\Services\StockService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RiwayatTransaksiController extends Controller
{
    public function __construct(
        protected StockTransactionService $transactionService,
        protected StockService $stockService,
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['type', 'status', 'date_from', 'date_to', 'product_id']);

        $transactions = $this->transactionService->getRiwayatWithFilter($filters);
        $products     = Product::orderBy('name')->get();
        $stockMap     = $this->stockService->getStockMap();

        return view('admin.riwayat-transaksi.index', compact(
            'transactions', 'products', 'stockMap', 'filters'
        ));
    }
}