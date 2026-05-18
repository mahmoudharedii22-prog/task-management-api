<?php

namespace App\Services;

use App\Contracts\CommentRepoInterface;
use App\Models\Comment;

class CommentService
{
    private $repo;

    public function __construct(CommentRepoInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(array $data)
    {
        return $this->repo->index($data);
    }
    public function store(array $data)
    {
        return $this->repo->store($data);
    }
    public function update(array $data, Comment $comment)
    {
        return $this->repo->update($data, $comment);
    }
    public function destroy(Comment $comment)
    {
        return $this->repo->destroy($comment);
    }
    public function find($comment_id)
    {
        return $this->repo->find($comment_id);
    }
}
