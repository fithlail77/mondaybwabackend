<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes; // Tambahkan Trait SoftDeletes

    // Kontrol Mass Assignment: Kolom yang diizinkan diisi dari formulir Transaksi
    protected $fillable = [
        'name',
        'phone',
        'sub_total',
        'tax_total',
        'grand_total',
        'merchant_id', // Menghubungkan transaksi ke Merchant/penjualan utama
    ];

    // Relasi 1: Transaction belongs to Merchant
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // Relasi 2: Transaction has Many TransactionProducts
    public function transactionProducts()
    {
        // Transaksi ini memiliki banyak item baris di tabel pivot TransactionProduct
        return $this->hasMany(TransactionProduct::class);
    }
}
