<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use SoftDeletes; // Tambahkan Trait SoftDeletes

    // Kontrol Mass Assignment: Mengizinkan kolom ini diisi secara massal
    protected $fillable = [
        'name',
        'photo',
        'tagline',
    ];

    public function products()
    {
        // Relasi One-to-Many: Satu Category memiliki banyak Product
        return $this->hasMany(Product::class);
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