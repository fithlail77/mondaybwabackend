<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll(array $fields)
    {
        return $this->productRepository->getAll($fields);
    }

    public function getById(int $id, array $fields)
    {
        return $this->productRepository->getById($id, $fields ?? ['*']);
    }

    public function create(array $data)
    {
         if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            $data['thumbnail'] = $this->uploadThumbnail($data['thumbnail']);
        }
        return $this->productRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $fields = ['id', 'thumbnail'];
        $product = $this->productRepository->getById($id, $fields);

        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            if (!empty($product->thumbnail)) {
                $this->deleteThumbnail($product->thumbnail);
            }
            $data['thumbnail'] = $this->uploadThumbnail($data['thumbnail']);
        }

        return $this->productRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $fields = ['id', 'thumbnail'];
        $product = $this->productRepository->getById($id, $fields);

        if ($product->thumbnail) {
            $this->deleteThumbnail($product->thumbnail);
        }
    
        $this->productRepository->delete($id);
    }

    private function uploadThumbnail(UploadedFile $thumbnail)
    {
        return $thumbnail->store('products', 'public');
    }

    private function deleteThumbnail(string $thumbnailPath)
    {
        $relativePath = 'products/' . basename($thumbnailPath);
    
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}