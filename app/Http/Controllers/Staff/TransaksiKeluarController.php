<?php

namespace App\Http\Controllers\Staff;

use App\Services\StockTransactionService;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class TransaksiKeluarController extends Controller
{
    public function __construct(
        protected StockTransactionService $transactionService,
        protected StockService $stockService,
    ) {}

    public function index()
    {
        $transactions = $this->transactionService
                            ->getTransaksiKeluarByStaff(Auth::id());

        $products = $this->stockService->getProductsWithStock();

        return view('staff.transaksi-keluar.index', compact('transactions', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'date'       => 'required|date',
            'notes'      => 'nullable|string|max:255',
        ], [
            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.exists'   => 'Produk tidak valid.',
            'quantity.required'   => 'Jumlah wajib diisi.',
            'quantity.min'        => 'Jumlah minimal 1.',
            'date.required'       => 'Tanggal wajib diisi.',
        ]);

        try {
            $this->transactionService->createTransaksiKeluar($request->all());

            return redirect()->route('staff.transaksi-keluar.index')
                ->with('success', 'Transaksi keluar berhasil diajukan dan menunggu konfirmasi Manajer.');

        } catch (\Exception $e) {
            return redirect()->route('staff.transaksi-keluar.index')
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
}