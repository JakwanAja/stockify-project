<?php

namespace App\Http\Controllers\Admin;

use App\Services\LaporanService;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;

class LaporanController extends Controller
{
    public function __construct(
        protected LaporanService $laporanService
    ) {}

    // ===== Laporan Stok =====
    public function stok(Request $request)
    {
        $categoryId  = $request->input('category_id');
        $produk      = $this->laporanService->getLaporanStok($categoryId);
        $perKategori = $this->laporanService->getLaporanStokPerKategori();
        $categories  = Category::orderBy('name')->get();

        return view('admin.laporan.stok', compact(
            'produk', 'perKategori', 'categories', 'categoryId'
        ));
    }

    public function stokPdf(Request $request)
    {
        $categoryId  = $request->input('category_id');
        $produk      = $this->laporanService->getLaporanStok($categoryId);
        $perKategori = $this->laporanService->getLaporanStokPerKategori();
        $category    = $categoryId ? Category::find($categoryId) : null;
        $generatedAt = now()->translatedFormat('l, d F Y H:i');

        $pdf = Pdf::loadView('admin.laporan.stok-pdf', compact(
            'produk', 'perKategori', 'category', 'generatedAt'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-stok-' . now()->format('Y-m-d') . '.pdf');
    }

    // ===== Laporan Transaksi =====
    public function transaksi(Request $request)
    {
        $filters      = $request->only(['type', 'status', 'date_from', 'date_to', 'product_id']);
        $transactions = $this->laporanService->getLaporanTransaksi($filters);
        $summary      = $this->laporanService->getSummaryTransaksi($filters);
        $products     = Product::orderBy('name')->get();

        return view('admin.laporan.transaksi', compact(
            'transactions', 'summary', 'products', 'filters'
        ));
    }

    public function transaksiPdf(Request $request)
    {
        $filters      = $request->only(['type', 'status', 'date_from', 'date_to', 'product_id']);
        $transactions = $this->laporanService->getLaporanTransaksi($filters);
        $summary      = $this->laporanService->getSummaryTransaksi($filters);
        $generatedAt  = now()->translatedFormat('l, d F Y H:i');

        $pdf = Pdf::loadView('admin.laporan.transaksi-pdf', compact(
            'transactions', 'summary', 'filters', 'generatedAt'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi-' . now()->format('Y-m-d') . '.pdf');
    }
}