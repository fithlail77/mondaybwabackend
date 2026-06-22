<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Merchant extends Model
{
    use SoftDeletes; // Tambahkan Trait SoftDeletes

    // Kontrol Mass Assignment: Mengizinkan kolom ini diisi dari formulir Add/Edit Merchant
    protected $fillable = [
        'name',
        'address',
        'photo',
        'phone',
        'keeper_id', // Penting: Menghubungkan Merchant dengan User (Keeper)
    ];

    // Relasi: Merchant belongs to User (the Keeper)
    public function keeper()
    {
        // Merchant terhubung ke User melalui kolom foreign key 'keeper_id'
        return $this->belongsTo(User::class, 'keeper_id');
    }

    // Relasi: Many-to-Many dengan Product, melalui tabel pivot 'merchant_products'
    public function products()
    {
        return $this->belongsToMany(Product::class, 'merchant_products')
            ->withPivot(['stock', 'warehouse_id']) // Mengambil kolom tambahan dari tabel pivot
            ->withTimestamps();
    }

    // Relasi: Merchant has Many Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Acessor: Mengubah path foto menjadi URL publik
    public function getPhotoAttribute($value)
    {
        if (!$value) {
            return null; // Tidak ada gambar
        }

        return url(Storage::url($value));
    }
}
