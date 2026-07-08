<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\StockTransaction;

class LaporanService
{
    public function __construct(
        protected StockService $stockService
    ) {}

    /**
     * Laporan stok semua produk
     */
    public function getLaporanStok(?int $categoryId = null)
    {
        $query = Product::with(['category', 'supplier']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->orderBy('name')->get();
        $stockMap = $this->stockService->getStockMap();

        return $products->map(function ($product) use ($stockMap) {
            $product->current_stock = $stockMap[$product->id] ?? 0;
            $product->stock_status  = $product->current_stock <= $product->minimum_stock
                ? 'Menipis' : 'Aman';
            return $product;
        });
    }

    /**
     * Laporan stok per kategori (summary)
     */
    public function getLaporanStokPerKategori()
    {
        $categories = Category::with('products')->get();
        $stockMap   = $this->stockService->getStockMap();

        return $categories->map(function ($category) use ($stockMap) {
            $totalStok   = 0;
            $totalMenipis = 0;

            foreach ($category->products as $product) {
                $stok = $stockMap[$product->id] ?? 0;
                $totalStok += $stok;
                if ($stok <= $product->minimum_stock) {
                    $totalMenipis++;
                }
            }

            return (object) [
                'name'           => $category->name,
                'total_produk'   => $category->products->count(),
                'total_stok'     => $totalStok,
                'total_menipis'  => $totalMenipis,
            ];
        })->sortByDesc('total_stok')->values();
    }

    /**
     * Laporan transaksi dengan filter
     */
    public function getLaporanTransaksi(array $filters = [])
    {
        $query = StockTransaction::with(['product', 'user']);

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('date', '<=', $filters['date_to']);
        }

        if (!empty($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }

        return $query->latest('date')->get();
    }

    /**
     * Summary laporan transaksi
     */
    public function getSummaryTransaksi(array $filters = []): array
    {
        $transactions = $this->getLaporanTransaksi($filters);

        $totalMasuk   = $transactions->where('type', 'Masuk')
                            ->whereIn('status', ['Diterima'])->sum('quantity');
        $totalKeluar  = $transactions->where('type', 'Keluar')
                            ->whereIn('status', ['Dikeluarkan'])->sum('quantity');
        $totalPending = $transactions->where('status', 'Pending')->count();
        $totalDitolak = $transactions->where('status', 'Ditolak')->count();

        return compact('totalMasuk', 'totalKeluar', 'totalPending', 'totalDitolak');
    }
}