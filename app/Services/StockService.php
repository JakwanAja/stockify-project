<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockTransaction;

class StockService
{
    /**
     * Hitung stok aktual sebuah produk
     * Stok = total masuk (Diterima) - total keluar (Dikeluarkan)
     */
    public function getStock(int $productId): int
    {
        $masuk = StockTransaction::where('product_id', $productId)
                    ->where('type', 'Masuk')
                    ->where('status', 'Diterima')
                    ->sum('quantity');

        $keluar = StockTransaction::where('product_id', $productId)
                    ->where('type', 'Keluar')
                    ->where('status', 'Dikeluarkan')
                    ->sum('quantity');

        return (int) ($masuk - $keluar);
    }

    public function getStockMap(): array
    {
        $masuk = StockTransaction::where('type', 'Masuk')
                    ->where('status', 'Diterima')
                    ->selectRaw('product_id, SUM(quantity) as total')
                    ->groupBy('product_id')
                    ->pluck('total', 'product_id')
                    ->toArray();

        $keluar = StockTransaction::where('type', 'Keluar')
                    ->where('status', 'Dikeluarkan')
                    ->selectRaw('product_id, SUM(quantity) as total')
                    ->groupBy('product_id')
                    ->pluck('total', 'product_id')
                    ->toArray();

        $allProductIds = Product::pluck('id')->toArray();

        $stockMap = [];
        foreach ($allProductIds as $id) {
            $in  = $masuk[$id]  ?? 0;
            $out = $keluar[$id] ?? 0;
            $stockMap[$id] = (int) ($in - $out);
        }

        return $stockMap;
    }

    /**
     * Cek apakah stok produk mencukupi untuk transaksi keluar
     */
    public function hasEnoughStock(int $productId, int $quantity): bool
    {
        return $this->getStock($productId) >= $quantity;
    }

    /**
     * Cek apakah stok produk di bawah minimum
     */
    public function isLowStock(Product $product): bool
    {
        return $this->getStock($product->id) <= $product->minimum_stock;
    }

    /**
     * Ambil semua produk yang stoknya di bawah minimum
     */
    public function getLowStockProducts()
    {
        $products  = Product::with('category')->get();
        $stockMap  = $this->getStockMap();

        return $products->filter(function ($product) use ($stockMap) {
            $stock = $stockMap[$product->id] ?? 0;
            return $stock <= $product->minimum_stock;
        })->map(function ($product) use ($stockMap) {
            $product->current_stock = $stockMap[$product->id] ?? 0;
            return $product;
        })->sortBy('current_stock')->values();
    }

    /**
     * Ambil semua produk beserta stok aktualnya untuk dropdown transaksi
     */
    public function getProductsWithStock()
    {
        $products = Product::with('category')->orderBy('name')->get();
        $stockMap = $this->getStockMap();

        return $products->map(function ($product) use ($stockMap) {
            $product->current_stock = $stockMap[$product->id] ?? 0;
            return $product;
        });
    }

    /**
     * Summary stok untuk dashboard
     */
    public function getDashboardSummary(): array
    {
        $products = Product::with('category')->get();
        $stockMap = $this->getStockMap();

        $totalLowStock = $products->filter(function ($product) use ($stockMap) {
            $stock = $stockMap[$product->id] ?? 0;
            return $stock <= $product->minimum_stock;
        })->count();

        return [
            'total_products' => $products->count(),
            'total_low_stock' => $totalLowStock,
            'stock_map' => $stockMap,
        ];
    }
}