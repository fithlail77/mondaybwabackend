<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function getAll()
    {
        // Menggunakan with() untuk memuat relasi sekaligus (Eager Loading)
        return User::with(['roles', 'merchant'])->get();
    }

    public function getById(int $id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        // Hash password
        $data['password'] = Hash::make($data['password']);

        // Handle upload foto jika ada
        if (isset($data['photo'])) {
            $data['photo'] = $data['photo']->store('users', 'public');
        }

        return User::create($data);
    }

    public function update(int $id, array $data)
    {
        $user = User::findOrFail($id);

        // Handle password update
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Jangan update password jika kosong
        }

        // Handle update foto
        if (isset($data['photo'])) {
            // Hapus foto lama jika ada
            if ($user->getRawOriginal('photo')) {
                Storage::disk('public')->delete($user->getRawOriginal('photo'));
            }
            $data['photo'] = $data['photo']->store('users', 'public');
        }

        $user->update($data);
        return $user;
    }

    public function delete(int $id)
    {
        $user = User::findOrFail($id);
        
        // Hapus foto dari storage jika ada
        if ($user->getRawOriginal('photo')) {
            Storage::disk('public')->delete($user->getRawOriginal('photo'));
        }

        return $user->delete();
    }
}