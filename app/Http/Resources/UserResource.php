<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'photo' => $this->photo, // Akan otomatis terformat berkat Accessor di Model User
            // Mengambil hanya 'name' dari tabel roles menjadi bentuk array flat ["manager", "admin"]
            'roles'    => $this->roles->pluck('name'),
            // Menampilkan data merchant (akan return null jika tidak punya relasi)
            'merchant' => $this->merchant,
        ];
    }
}
