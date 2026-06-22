<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'thumbnail' => $this->thumbnail,
            'about' => $this->about,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'is_popular' => $this->is_popular,
            
            // Relasi hanya muncul jika di-load dengan with('category')
            'category' => $this->whenLoaded('category'), 
            
            // Timestamps hanya muncul jika tersedia di objek data (seperti saat Update)
            'deleted_at' => $this->whenHas('deleted_at'),
            'created_at' => $this->whenHas('created_at'),
            'updated_at' => $this->whenHas('updated_at'), 
        ];
    }
}
