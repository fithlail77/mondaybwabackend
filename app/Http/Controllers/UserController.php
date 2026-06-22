<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAll();
        return response()->json(UserResource::collection($users));
    }

    public function show(int $id)
    {
        $user = $this->userService->getById($id);
        return response()->json(new UserResource($user));
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->create($request->validated());
        return response()->json(new UserResource($user), 201);
    }

    public function update(UserRequest $request, int $id)
    {
        $user = $this->userService->update($id, $request->validated());
        return response()->json(new UserResource($user));
    }

    public function destroy(int $id)
    {
        $this->userService->delete($id);
        return response()->json(['message' => 'User deleted successfully']);
    }
}
