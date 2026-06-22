<?php

namespace App\Http\Controllers;

use App\Http\Requests\MerchantProductRequest;
use App\Http\Requests\MerchantProductUpdateRequest;
use App\Services\MerchantService;
use Illuminate\Http\Request;

class MerchantProductController extends Controller
{
    private MerchantService $merchantService;

    public function __construct(MerchantService $merchantService)
    {
        $this->merchantService = $merchantService;
    }

    public function attach(MerchantProductRequest $request, int $merchantId)
    {
        // Service sekarang mengembalikan data pivot
        $merchantProduct = $this->merchantService->attachProduct(
            $merchantId,
            $request->input('product_id'),
            $request->input('stock'),
            $request->input('warehouse_id')
        );

        // Sesuaikan response dengan format dan status 201 (Created)
        return response()->json([
            'message' => 'Product assigned to merchant successfully',
            'data' => $merchantProduct
        ], 201);
    }

    public function detach(int $merchantId, int $productId)
    {
        $this->merchantService->detachProduct($merchantId, $productId);

        return response()->json(['message' => 'Product detached successfully']);
    }

    public function update(MerchantProductUpdateRequest $request, int $merchantId, int $productId)
    {
        $merchantProduct = $this->merchantService->updateProductStock(
            $merchantId,
            $productId,
            $request->validated()['stock'],
            $request->input('warehouse_id'),
        );

        return response()->json([
            'message' => 'Stock updated successfully',
            'data' => $merchantProduct,
        ]);   
    }
}

