<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => $this->photo,
            'address' => $this->address,
            'phone' => $this->phone,
            'keeper_id' => $this->keeper_id,
            
            // Tambahkan baris ini untuk memunculkan objek relasi
            'keeper' => $this->whenLoaded('keeper'), 
            
            // Tambahkan baris ini untuk memunculkan list produk beserta pivot dan category-nya
            'products'   => $this->whenLoaded('products'),
            
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
