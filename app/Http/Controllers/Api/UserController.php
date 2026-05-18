<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;

    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $filters = $request->only(['name', 'email']);
        $users = $this->service->index($filters);

        return response()->json([
            'success' => true,
            'data' => UserResource::collection($users),
            'message' => 'User retrieved successfully',
        ], 200);
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        $data = $request->validated();
        
        $user = $this->service->store($data);

        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
            'message' => 'User created successfully',
        ], 201);
    }

    public function show($id)
    {
        $user = $this->service->find($id);
        $this->authorize('view', $user);

        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
            'message' => 'User retrieved successfully',
        ], 200);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();
        $user = $this->service->find($id);
        $this->authorize('update', $user);
        $user = $this->service->update($data, $user);

        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
            'message' => 'User updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $user = $this->service->find($id);
        $this->authorize('delete', $user);

        $this->service->destroy($user);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'User deleted successfully',
        ], 200);
    }
}
