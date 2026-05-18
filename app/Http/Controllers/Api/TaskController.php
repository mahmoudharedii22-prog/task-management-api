<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    protected $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        $tasks = $this->service->index($request->all());

        if ($tasks->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'no tasks found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => TaskResource::collection($tasks),
            'message' => 'these are all tasks',
        ], 200);
    }

    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create', Task::class);
        $data = $request->validated();
        $data['author_id'] = $request->user()->id;
        $task = $this->service->store($data);
        

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
            'message' => 'task created successfully',
        ], 201);
    }

    public function update(UpdateTaskRequest $request, $task_id)
    {
        $task = $this->service->find($task_id);
        $this->authorize('update', $task);
        $task = $this->service->update($request->validated(), $task);

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
            'message' => 'Task updated successfully',
        ], 200);
    }

    public function destroy($task_id)
    {
        $task = $this->service->find($task_id);
        $this->authorize('delete', $task);
        $this->service->destroy($task);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'task deleted successfully',
        ], 200);
    }

    public function show($task_id)
    {
        $task = $this->service->find($task_id);
        $this->authorize('view', $task);
        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
            'message' => 'task retrieved successfully',
        ], 200);
    }
}
