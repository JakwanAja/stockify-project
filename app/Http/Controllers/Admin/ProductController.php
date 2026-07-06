<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\ProductService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service
    ) {}

    public function index()
    {
        $products   = $this->service->getAllProducts();
        $categories = $this->service->getAllCategories();
        $suppliers  = $this->service->getAllSuppliers();
        $stockMap   = app(\App\Services\StockService::class)->getStockMap();
    
        return view('admin.products.index', compact('products', 'categories', 'suppliers', 'stockMap'));
    }

    public function create()
    {
        $categories = $this->service->getAllCategories();
        $suppliers  = $this->service->getAllSuppliers();
        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'supplier_id'    => 'required|exists:suppliers,id',
            'name'           => 'required|string|max:45',
            'sku'            => 'required|string|max:45|unique:products,sku',
            'description'    => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'minimum_stock'  => 'required|integer|min:0',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'category_id.required'    => 'Kategori wajib dipilih.',
            'category_id.exists'      => 'Kategori tidak valid.',
            'supplier_id.required'    => 'Supplier wajib dipilih.',
            'supplier_id.exists'      => 'Supplier tidak valid.',
            'name.required'           => 'Nama produk wajib diisi.',
            'name.max'                => 'Nama produk maksimal 45 karakter.',
            'sku.required'            => 'SKU wajib diisi.',
            'sku.unique'              => 'SKU sudah digunakan produk lain.',
            'purchase_price.required' => 'Harga beli wajib diisi.',
            'purchase_price.numeric'  => 'Harga beli harus berupa angka.',
            'selling_price.required'  => 'Harga jual wajib diisi.',
            'selling_price.numeric'   => 'Harga jual harus berupa angka.',
            'minimum_stock.required'  => 'Stok minimum wajib diisi.',
            'minimum_stock.integer'   => 'Stok minimum harus berupa angka bulat.',
            'image.image'             => 'File harus berupa gambar.',
            'image.mimes'             => 'Format gambar: jpg, jpeg, png, webp.',
            'image.max'               => 'Ukuran gambar maksimal 2MB.',
        ]);

        $this->service->createProduct($request->all(), $request->file('image'));

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $product    = $this->service->getProductById($id);
        $categories = $this->service->getAllCategories();
        $suppliers  = $this->service->getAllSuppliers();
        $attributes = $this->service->getProductAttributes($id);
        return view('admin.products.edit', compact('product', 'categories', 'suppliers', 'attributes'));
    }
    
    public function update(Request $request, int $id)
    {
        $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'supplier_id'      => 'required|exists:suppliers,id',
            'name'             => 'required|string|max:45',
            'sku'              => 'required|string|max:45|unique:products,sku,' . $id,
            'description'      => 'nullable|string',
            'purchase_price'   => 'required|numeric|min:0',
            'selling_price'    => 'required|numeric|min:0',
            'minimum_stock'    => 'required|integer|min:0',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'attributes'       => 'nullable|array',
            'attributes.*.name'  => 'required_with:attributes.*.value|string|max:45',
            'attributes.*.value' => 'required_with:attributes.*.name|string|max:45',
        ], [
            'category_id.required'    => 'Kategori wajib dipilih.',
            'supplier_id.required'    => 'Supplier wajib dipilih.',
            'name.required'           => 'Nama produk wajib diisi.',
            'sku.required'            => 'SKU wajib diisi.',
            'sku.unique'              => 'SKU sudah digunakan produk lain.',
            'purchase_price.required' => 'Harga beli wajib diisi.',
            'selling_price.required'  => 'Harga jual wajib diisi.',
            'minimum_stock.required'  => 'Stok minimum wajib diisi.',
            'image.image'             => 'File harus berupa gambar.',
            'image.mimes'             => 'Format gambar: jpg, jpeg, png, webp.',
            'image.max'               => 'Ukuran gambar maksimal 2MB.',
        ]);
    
        $this->service->updateProduct(
            $id,
            $request->all(),
            $request->file('image'),
            $request->input('attributes', [])
        );
    
        return redirect()->route('admin.products.edit', $id)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->service->deleteProduct($id);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}