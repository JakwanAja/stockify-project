<?php

namespace App\Services\Admin;

use App\Repositories\Interfaces\SupplierRepositoryInterface;

class SupplierService
{
    public function __construct(
        protected SupplierRepositoryInterface $repository
    ) {}

    public function getAllSuppliers()
    {
        return $this->repository->getAll();
    }

    public function getSupplierById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function createSupplier(array $data)
    {
        return $this->repository->create([
            'name'    => $data['name'],
            'address' => $data['address'] ?? null,
            'phone'   => $data['phone'] ?? null,
            'email'   => $data['email'] ?? null,
        ]);
    }

    public function updateSupplier(int $id, array $data)
    {
        return $this->repository->update($id, [
            'name'    => $data['name'],
            'address' => $data['address'] ?? null,
            'phone'   => $data['phone'] ?? null,
            'email'   => $data['email'] ?? null,
        ]);
    }

    public function deleteSupplier(int $id)
    {
        return $this->repository->delete($id);
    }
}