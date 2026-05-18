<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request , $task_id)
    {
        $this->authorize('viewAny', Comment::class);
        $filters = $request->only(['query','author_id']);
        $filters['task_id'] = $task_id;
        $comments = $this->service->index($filters);

        return response()->json([
            'success' => true,
            'data' => CommentResource::collection($comments),
            'message' => 'Comments retrieved successfully',
        ], 200);
    }

    public function store(StoreCommentRequest $request, $task_id)
    {
        $this->authorize('create', Comment::class);
        $data = $request->validated();
        $data['task_id'] = $task_id;
        $data['author_id'] = auth()->id();
        $comment = $this->service->store($data);

        return response()->json([
            'success' => true,
            'data' => new CommentResource($comment),
            'message' => 'Comment created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($task_id, $comment_id)
    {
        $comment = $this->service->find($comment_id);
        if ($comment->task_id !== (int) $task_id) {
            return response()->json([
                'success' => false,
                'message' => 'Comment does not belong to this task',
            ], 403);
        }
        $this->authorize('view', $comment);

        return response()->json([
            'success' => true,
            'data' => new CommentResource($comment),
            'message' => 'Comment retrieved successfully',
        ], 200);
    }

    public function update(UpdateCommentRequest $request,$task_id, $comment_id)
    {
        $comment = $this->service->find($comment_id);
        if ($comment->task_id !== (int) $task_id) {
            return response()->json([
                'success' => false,
                'message' => 'Comment does not belong to this task',
            ], 403);
        }
        $this->authorize('update', $comment);
        $data = $request->validated();
        $comment = $this->service->update($data, $comment);

        return response()->json([
            'success' => true,
            'data' => new CommentResource($comment),
            'message' => 'Comment updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($task_id, $comment_id)
    {
        $comment = $this->service->find($comment_id);
        if ($comment->task_id !== (int) $task_id) {
            return response()->json([
                'success' => false,
                'message' => 'Comment does not belong to this task',
            ], 403);
        }
        $this->authorize('delete', $comment);
        $this->service->destroy($comment);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Comment deleted successfully',
        ], 200);
    }
}
