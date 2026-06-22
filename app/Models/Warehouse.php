<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Warehouse extends Model
{
    use SoftDeletes;

    // Mass Assignment: Kolom yang diizinkan
    protected $fillable = [
        'name',
        'address',
        'photo',
        'phone',
    ];

    // Relasi: Many-to-Many dengan Product (Stok Fisik)
    public function products()
    {
        // Menghubungkan Warehouse dengan Product melalui tabel pivot 'warehouse_products'
        return $this->belongsToMany(Product::class, 'warehouse_products')
            ->withPivot('stock') // Mengambil kolom 'stock' dari tabel pivot
            ->withTimestamps(); // Agar timestamps (created_at, updated_at) dari pivot table juga diambil
    }

    // Accessor: Mengambil kolom 'photo' dan mengembalikannya sebagai URL
    public function getPhotoAttribute($value)
    {
        if (!$value) {
            return null;
        }
        // Menggabungkan path storage dengan nilai kolom 'photo'
        return url(Storage::url($value));
    }
}
