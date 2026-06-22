<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseProduct extends Model
{
    use SoftDeletes; // Tambahkan Trait SoftDeletes

    // Mass Assignment: Kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'warehouse_id',
        'product_id',
        'stock',
    ];

    // Relasi 1: Menghubungkan kembali ke Warehouse
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    // Relasi 2: Menghubungkan kembali ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
