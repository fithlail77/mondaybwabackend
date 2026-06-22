<?php

namespace App\Repositories;

use App\Models\Merchant;

class MerchantRepository
{
    public function getAll(array $fields = ['*'])
    {
        return Merchant::with('keeper', 'products.category')->get($fields);
    }

    public function getById(int $id, array $fields)
    {
        return Merchant::with('keeper')->select($fields)->findOrFail($id);
    }

    public function create(array $data)
    {
        return Merchant::create($data);
    }

    public function update(int $id, array $data)
    {
        $merchant = Merchant::findOrFail($id);
        $merchant->update($data);
    
        return $merchant;
    }

    public function delete(int $id)
    {
        $merchant = Merchant::findOrFail($id);
        $merchant->delete();
    }

    // Tambahkan fungsi ini di dalam class MerchantRepository
    public function getByKeeperId(int $keeperId, array $fields)
    {
        // Menggunakan with('keeper') agar data relasi user ikut terbawa
        return Merchant::with('keeper')
            ->select($fields)
            ->where('keeper_id', $keeperId)
            ->first();
    }
}