<?php

namespace App\Services;

use App\Repositories\Interfaces\StockTransactionRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class StockTransactionService
{
    public function __construct(
        protected StockTransactionRepositoryInterface $repository,
        protected StockService $stockService,
    ) {}

    // ===== Staff: Input Transaksi Masuk =====
    public function createTransaksiMasuk(array $data)
    {
        return $this->repository->create([
            'product_id' => $data['product_id'],
            'user_id'    => Auth::id(),
            'type'       => 'Masuk',
            'quantity'   => $data['quantity'],
            'date'       => $data['date'],
            'status'     => 'Pending',
            'notes'      => $data['notes'] ?? null,
        ]);
    }

    // Staff: Lihat transaksi masuk miliknya
    public function getTransaksiMasukByStaff(int $userId)
    {
    return $this->repository->getByUserAndType($userId, 'Masuk');
    }

    // ===== Manajer: Lihat semua transaksi masuk pending =====
    public function getAllTransaksiMasukPending()
    {
        return $this->repository->getByTypeAndStatus('Masuk', 'Pending');
    }

    // ===== Manajer: Lihat semua transaksi masuk =====
    public function getAllTransaksiMasuk()
    {
        return $this->repository->getByType('Masuk');
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }
    // ===== Manajer: Konfirmasi transaksi masuk =====
    public function konfirmasiMasuk(int $id)
    {
        $transaction = $this->repository->findById($id);

        if (!$transaction->isPending()) {
            throw new \Exception('Transaksi ini sudah diproses sebelumnya.');
        }

        if ($transaction->type !== 'Masuk') {
            throw new \Exception('Transaksi bukan tipe Masuk.');
        }
        $this->repository->updateStatus($id, 'Diterima');
    }

    // ===== Manajer: Tolak transaksi masuk =====
    public function tolakMasuk(int $id)
    {
        $transaction = $this->repository->findById($id);

        if (!$transaction->isPending()) {
            throw new \Exception('Transaksi ini sudah diproses sebelumnya.');
        }

        $this->repository->updateStatus($id, 'Ditolak');
    }
}