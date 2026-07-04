<?php

namespace App\Repositories\Interfaces;

interface ProductAttributeRepositoryInterface
{
    public function getByProductId(int $productId);
    public function deleteByProductId(int $productId);
    public function bulkCreate(int $productId, array $attributes);
}