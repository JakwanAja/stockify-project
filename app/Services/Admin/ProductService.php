<?php

namespace App\Services\Admin;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\SupplierRepositoryInterface;
use App\Repositories\Interfaces\ProductAttributeRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface          $productRepository,
        protected CategoryRepositoryInterface         $categoryRepository,
        protected SupplierRepositoryInterface         $supplierRepository,
        protected ProductAttributeRepositoryInterface $attributeRepository,
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

    public function getProductAttributes(int $productId)
    {
        return $this->attributeRepository->getByProductId($productId);
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

    public function updateProduct(int $id, array $data, ?UploadedFile $image = null, array $attributes = [])
    {
        $product = $this->productRepository->findById($id);

        if ($image) {
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }
            $data['image'] = $this->uploadImage($image);
        } else {
            $data['image'] = $product->image;
        }

        $this->productRepository->update($id, [
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

        // Sync atribut: hapus semua lama, insert yang baru
        $this->attributeRepository->deleteByProductId($id);
        if (!empty($attributes)) {
            $this->attributeRepository->bulkCreate($id, $attributes);
        }
    }

    public function deleteProduct(int $id)
    {
        // Hapus atribut dulu sebelum hapus produk
        $this->attributeRepository->deleteByProductId($id);
        return $this->productRepository->delete($id);
    }

    private function uploadImage(UploadedFile $image): string
    {
        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/products'), $filename);
        return $filename;
    }
}