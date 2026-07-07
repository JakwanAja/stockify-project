<?php

namespace App\Repositories\Eloquent;

use App\Models\StockTransaction;
use App\Repositories\Interfaces\StockTransactionRepositoryInterface;

class StockTransactionRepository implements StockTransactionRepositoryInterface
{
    public function getAll()
    {
        return StockTransaction::with(['product', 'user'])
            ->latest('created_at')
            ->get();
    }

    public function getByType(string $type)
    {
        return StockTransaction::with(['product', 'user'])
            ->where('type', $type)
            ->latest('created_at')
            ->get();
    }

    public function getByTypeAndStatus(string $type, string $status)
    {
        return StockTransaction::with(['product', 'user'])
            ->where('type', $type)
            ->where('status', $status)
            ->latest('created_at')
            ->get();
    }

    public function getByUserAndType(int $userId, string $type)
    {
    return StockTransaction::with(['product'])
        ->where('user_id', $userId)
        ->where('type', $type)
        ->latest('created_at')
        ->get();
    }

    public function getByUser(int $userId)
    {
        return StockTransaction::with(['product'])
            ->where('user_id', $userId)
            ->latest('created_at')
            ->get();
    }

    public function findById(int $id)
    {
        return StockTransaction::with(['product', 'user'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return StockTransaction::create($data);
    }

    public function updateStatus(int $id, string $status)
    {
        $transaction = StockTransaction::findOrFail($id);
        $transaction->update(['status' => $status]);
        return $transaction;
    }

    public function getWithFilter(array $filters)
    {
        $query = StockTransaction::with(['product', 'user']);

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('date', '<=', $filters['date_to']);
        }

        if (!empty($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }

        return $query->latest('created_at')->get();
    }
    
}