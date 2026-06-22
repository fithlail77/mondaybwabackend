<?php

namespace App\Http\Controllers;

use App\Http\Requests\MerchantRequest;
use App\Http\Resources\MerchantResource;
use App\Services\MerchantService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    private MerchantService $merchantService;

    public function __construct(MerchantService $merchantService)
    {
        $this->merchantService = $merchantService;
    }

    public function index()
    {
        $merchants = $this->merchantService->getAll(['*']);

        return MerchantResource::collection($merchants);
    }

    public function show(int $id)
    {
        try {
            $fields = ['id', 'name', 'photo', 'address','phone','keeper_id'];
            $merchant = $this->merchantService->getById($id, $fields);

            return response()->json([new MerchantResource($merchant)]);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                'message' => 'merchant not found',
                ], 404);
            }
    }

    public function store(MerchantRequest $request)
    {
        $merchant = $this->merchantService->create($request->validated());

        return response()->json(new MerchantResource($merchant), 201);
    }

    public function update(MerchantRequest $request, int $id)
    {
        try {
            $merchant = $this->merchantService->update($id, $request->validated());
            return response()->json(new MerchantResource($merchant));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'merchant not found',
            ], 404);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->merchantService->delete($id);
            return response()->json([
                'message' => 'merchant deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'merchant not found',
            ], 404);
        }
    }

    // Tambahkan fungsi ini di dalam class MerchantController
    public function getMyMerchantProfile(Request $request)
    {
        // Pastikan route ini dilindungi oleh middleware auth (contoh: auth:sanctum)
        $user = $request->user(); 

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Harap login terlebih dahulu.'
            ], 401);
        }

        $fields = ['id', 'name', 'photo', 'address', 'phone', 'keeper_id'];
        
        // Cari merchant berdasarkan ID user yang sedang login
        $merchant = $this->merchantService->getByKeeperId($user->id, $fields);

        // Jika user ini belum punya merchant
        if (!$merchant) {
            return response()->json([
                'message' => 'Anda belum memiliki data merchant.'
            ], 404);
        }

        return response()->json(new MerchantResource($merchant));
    }
}
