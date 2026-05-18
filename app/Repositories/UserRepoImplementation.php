<?php

namespace App\Repositories;

use App\Contracts\UserRepoInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepoImplementation implements UserRepoInterface
{


    public function index(array $filters): Collection
    {

        $query = User::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        return $query->get();
    }

    public function find($id): User
    {
        
        return User::findOrFail($id);
    }

    public function store(array $data): User
    {
        return User::create($data);
    }

    public function update(array $data, User $user): User
    {
        $user->update($data);

        return $user;
    }

    public function destroy(User $user): bool
    {
        return $user->delete();
    }
}
