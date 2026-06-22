<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionProduct extends Model
{
    use SoftDeletes; // Tambahkan Trait SoftDeletes

    // Mass Assignment: Kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'sub_total', // Harga * Quantity
    ];

    // Relasi 1: Menghubungkan kembali ke Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi 2: Menghubungkan kembali ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
