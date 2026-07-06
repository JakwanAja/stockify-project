<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $table = 'stock_transactions';

    protected $fillable = [
        'product_id', 'user_id', 'type',
        'quantity', 'date', 'status', 'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ===== Helper Status =====
    public function isPending(): bool
    {
        return $this->status === 'Pending';
    }

    public function isDiterima(): bool
    {
        return $this->status === 'Diterima';
    }

    public function isDikeluarkan(): bool
    {
        return $this->status === 'Dikeluarkan';
    }

    public function isDitolak(): bool
    {
        return $this->status === 'Ditolak';
    }
}