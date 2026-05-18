<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepoInterface
{
    public function index(array $filters): Collection;

    public function find($id) : User;

    public function store(array $data) : User;

    public function update(array $data, User $user) : User;

    public function destroy(User $user) : bool;
}
