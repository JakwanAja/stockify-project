<?php

namespace App\Repositories\Interfaces;

interface StockTransactionRepositoryInterface
{
    public function getAll();
    public function getByType(string $type);
    public function getByTypeAndStatus(string $type, string $status);
    public function getByUserAndType(int $userId, string $type);

    public function getByUser(int $userId);
    public function findById(int $id);
    public function create(array $data);
    public function updateStatus(int $id, string $status);
}