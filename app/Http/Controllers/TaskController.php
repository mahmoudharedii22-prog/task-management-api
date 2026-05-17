<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskAPiResource;
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

        $tasks = $this->service->index($request->all());

        if ($tasks->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'no tasks found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => TaskAPiResource::collection($tasks),
            'message' => 'these are all tasks',
        ], 200);
    }

    public function store(CreateTaskRequest $request)
    {
        $task = $this->service->store($request->validated());

        return response()->json([
            'success' => true,
            'data' => new TaskAPiResource($task),
            'message' => 'task created successfully',
        ], 201);
    }

    public function update(UpdateTaskRequest $request, $task_id)
    {
        $task = $this->service->update($request->validated(), $task_id);

        return response()->json([
            'success' => true,
            'data' => new TaskAPiResource($task),
            'message' => 'Task updated successfully',
        ], 200);
    }

    public function destroy($task_id)
    {
        $this->service->destroy($task_id);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'task deleted successfully',
        ], 200);
    }

    public function show($task_id)
    {
        $task = $this->service->show($task_id);

        return response()->json([
            'success' => true,
            'data' => new TaskAPiResource($task),
            'message' => 'task retrieved successfully',
        ], 200);
    }
}
