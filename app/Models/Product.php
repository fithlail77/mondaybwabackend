<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use SoftDeletes; // Tambahkan Trait SoftDeletes

    // Kontrol Mass Assignment: Kolom yang diizinkan diisi dari formulir
    protected $fillable = [
        'name',
        'thumbnail',
        'about',
        'price',
        'category_id',
        'is_popular',
    ];

    // Relasi 1: Product belongs to a Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi 2: Many-to-Many dengan Merchant (untuk melacak kepemilikan stok)
    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_products')
            ->withPivot('stock') // Mengambil kolom 'stock' dari tabel pivot
            ->withTimestamps(); // Mengambil kolom timestamps dari tabel pivot
    }

    // Relasi 3: Many-to-Many dengan Warehouse (untuk melacak stok di gudang)
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_products')
            ->withPivot('stock') // Mengambil kolom 'stock' dari tabel pivot
            ->withTimestamps(); // Mengambil kolom timestamps dari tabel pivot
    }

    // Relasi 4: Product has Many TransactionProducts (Item yang terjual)
    public function transactions()
    {
        return $this->hasMany(TransactionProduct::class);
    }

    // Helper: Menghitung total stok produk di semua Warehouse
    public function getWarehouseProductStock()
    {
        // Menggunakan relasi warehouses() dan menjumlahkan kolom 'stock' dari pivot table
        return $this->warehouses()->sum('stock');
    }

    // Helper: Menghitung total stok kepemilikan Merchant
    public function getMerchantProductStock()
    {
        // Menggunakan relasi merchants() dan menjumlahkan kolom 'stock' dari pivot table
        return $this->merchants()->sum('stock');
    }

    // Accessor: Mengubah path thumbnail menjadi URL publik
    public function getThumbnailAttribute($value)
    {
        if (!$value) {
            return null;
        } 
        
        return url(Storage::url($value));
    }
}
