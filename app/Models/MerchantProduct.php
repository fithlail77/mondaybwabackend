<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantProduct extends Model
{
    use SoftDeletes;

    // Mass Assignment: Kolom yang diizinkan
    protected $fillable = [
        'merchant_id',
        'product_id',
        'stock',
        'warehouse_id',
    ];

    // Relasi: Menghubungkan kembali ke Merchant
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // Relasi: Menghubungkan kembali ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Menghubungkan kembali ke Warehouse
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
