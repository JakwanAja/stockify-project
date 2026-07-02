<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = ['name', 'address', 'phone', 'email'];

    public function products()
    {
        return $this->hasMany(Product::class, 'supplier_id');
    }
}