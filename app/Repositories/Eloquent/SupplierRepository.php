<?php

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use App\Repositories\Interfaces\SupplierRepositoryInterface;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function getAll()
    {
        return Supplier::latest()->get();
    }

    public function findById(int $id)
    {
        return Supplier::findOrFail($id);
    }

    public function create(array $data)
    {
        return Supplier::create($data);
    }

    public function update(int $id, array $data)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($data);
        return $supplier;
    }

    public function delete(int $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
    }
}