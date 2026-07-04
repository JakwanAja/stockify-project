<?php

namespace App\Services\Admin;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\SupplierRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface  $productRepository,
        protected CategoryRepositoryInterface $categoryRepository,
        protected SupplierRepositoryInterface $supplierRepository,
    ) {}

    public function getAllProducts()
    {
        return $this->productRepository->getAll();
    }

    public function getProductById(int $id)
    {
        return $this->productRepository->findById($id);
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }

    public function getAllSuppliers()
    {
        return $this->supplierRepository->getAll();
    }

    public function createProduct(array $data, ?UploadedFile $image = null)
    {
        $data['image'] = $image ? $this->uploadImage($image) : null;

        return $this->productRepository->create([
            'category_id'    => $data['category_id'],
            'supplier_id'    => $data['supplier_id'],
            'name'           => $data['name'],
            'sku'            => $data['sku'],
            'description'    => $data['description'] ?? null,
            'purchase_price' => $data['purchase_price'],
            'selling_price'  => $data['selling_price'],
            'image'          => $data['image'],
            'minimum_stock'  => $data['minimum_stock'],
        ]);
    }

    public function updateProduct(int $id, array $data, ?UploadedFile $image = null)
    {
        $product = $this->productRepository->findById($id);

        if ($image) {
            // Hapus gambar lama
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }
            $data['image'] = $this->uploadImage($image);
        } else {
            $data['image'] = $product->image;
        }

        return $this->productRepository->update($id, [
            'category_id'    => $data['category_id'],
            'supplier_id'    => $data['supplier_id'],
            'name'           => $data['name'],
            'sku'            => $data['sku'],
            'description'    => $data['description'] ?? null,
            'purchase_price' => $data['purchase_price'],
            'selling_price'  => $data['selling_price'],
            'image'          => $data['image'],
            'minimum_stock'  => $data['minimum_stock'],
        ]);
    }

    public function deleteProduct(int $id)
    {
        return $this->productRepository->delete($id);
    }

    private function uploadImage(UploadedFile $image): string
    {
        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/products'), $filename);
        return $filename;
    }
}