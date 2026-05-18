<?php

namespace App\Repositories;

use App\Contracts\CommentRepoInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentRepoImplementation implements CommentRepoInterface
{
    public function index(array $data): Collection
    {
        $query = Comment::query();
        
        $query->when(isset($data['query']), function ($query) use ($data) {
            return $query->where('content', 'like', '%'.$data['query'].'%');
        });
        $query->when(isset($data['task_id']), function ($query) use ($data) {
            return $query->where('task_id', $data['task_id']);
        });

        $query->when(isset($data['author_id']), function ($query) use ($data) {
            return $query->where('author_id', $data['author_id']);
        });

        return $query->get();
    }

    public function find($comment_id): Comment
    {
        return Comment::findOrFail($comment_id);
    }

    public function store(array $data): Comment
    {
        return Comment::create($data);
    }

    public function update(array $data, Comment $comment): Comment
    {
        $comment->update($data);

        return $comment->fresh();
    }

    public function destroy(Comment $comment): bool
    {
        return $comment->delete();
    }
}
