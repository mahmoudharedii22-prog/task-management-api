<?php

namespace App\Services;

use App\Contracts\UserRepoInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService
{
    private $repo;

    public function __construct(UserRepoInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(array $data)
    {
        return $this->repo->index($data);
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->repo->store($data);
    }
    public function update(array $data, User $user)
    {
        return $this->repo->update($data, $user);
    }

    public function destroy(User $user)
    {
        return $this->repo->destroy($user);
    }

}
