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

    // ===== Staff: Input Transaksi Keluar =====
    public function createTransaksiKeluar(array $data)
    {
        if (!$this->stockService->hasEnoughStock($data['product_id'], $data['quantity'])) {
            $stokTersedia = $this->stockService->getStock($data['product_id']);
            throw new \Exception("Stok tidak mencukupi. Stok tersedia: {$stokTersedia} unit.");
        }

        return $this->repository->create([
            'product_id' => $data['product_id'],
            'user_id'    => Auth::id(),
            'type'       => 'Keluar',
            'quantity'   => $data['quantity'],
            'date'       => $data['date'],
            'status'     => 'Pending',
            'notes'      => $data['notes'] ?? null,
        ]);
    }

    // ===== Staff: Lihat transaksi keluar miliknya =====
    public function getTransaksiKeluarByStaff(int $userId)
    {
        return $this->repository->getByUserAndType($userId, 'Keluar');
    }

    // ===== Manajer: Lihat semua transaksi keluar =====
    public function getAllTransaksiKeluarPending()
    {
        return $this->repository->getByTypeAndStatus('Keluar', 'Pending');
    }

    // ===== Manajer: Lihat semua transaksi keluar =====
    public function getAllTransaksiKeluar()
    {
        return $this->repository->getByType('Keluar');
    }

    // ===== Manajer: Konfirmasi transaksi keluar =====
    public function konfirmasiKeluar(int $id)
    {
        $transaction = $this->repository->findById($id);

        if (!$transaction->isPending()) {
            throw new \Exception('Transaksi ini sudah diproses sebelumnya.');
        }

        if ($transaction->type !== 'Keluar') {
            throw new \Exception('Transaksi bukan tipe Keluar.');
        }

        // Validasi ulang stok saat konfirmasi
        if (!$this->stockService->hasEnoughStock($transaction->product_id, $transaction->quantity)) {
            $stokTersedia = $this->stockService->getStock($transaction->product_id);
            throw new \Exception("Stok tidak mencukupi untuk dikonfirmasi. Stok tersedia: {$stokTersedia} unit.");
        }

        $this->repository->updateStatus($id, 'Dikeluarkan');
    }

    public function tolakKeluar(int $id)
    {
        $transaction = $this->repository->findById($id);

        if (!$transaction->isPending()) {
            throw new \Exception('Transaksi ini sudah diproses sebelumnya.');
        }

        $this->repository->updateStatus($id, 'Ditolak');
    }

    public function getRiwayatWithFilter(array $filters)
    {
        return $this->repository->getWithFilter($filters);
    }
}