<?php

namespace App\Contracts;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepoInterface
{
    public function index(array $data): Collection;

    public function find($comment_id):Comment;

    public function store(array $data):Comment;

    public function update(array $data, Comment $comment):Comment;

    public function destroy(Comment $comment):bool;
}
