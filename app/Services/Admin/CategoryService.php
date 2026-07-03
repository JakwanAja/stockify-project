<?php

namespace App\Services\Admin;

use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $repository
    ) {}

    public function getAllCategories()
    {
        return $this->repository->getAll();
    }

    public function getCategoryById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function createCategory(array $data)
    {
        return $this->repository->create([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function updateCategory(int $id, array $data)
    {
        return $this->repository->update($id, [
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function deleteCategory(int $id)
    {
        return $this->repository->delete($id);
    }
}