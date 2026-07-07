<?php

namespace App\Http\Controllers\Manager;

use App\Services\Admin\ProductService;
use App\Services\StockService;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected StockService $stockService,
    ) {}

    public function index()
    {
        $products = $this->productService->getAllProducts();
        $stockMap = $this->stockService->getStockMap();

        return view('manager.products.index', compact('products', 'stockMap'));
    }

    public function show(int $id)
    {
        $product    = $this->productService->getProductById($id);
        $attributes = $this->productService->getProductAttributes($id);
        $stock      = $this->stockService->getStock($id);

        return view('manager.products.show', compact('product', 'attributes', 'stock'));
    }
}