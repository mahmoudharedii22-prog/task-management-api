<?php

namespace App\Repositories;

use App\Contracts\TaskRepoInterface;
use App\Exceptions\TaskStatusException;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepoImplementation implements TaskRepoInterface
{
    public function index(array $data)
    {
        $query = Task::query();

        if(! Auth::user()->hasRole('admin')) {
            $query->where('assigned_to', Auth::id());
        }

        // Filters & Search
        $query->when(isset($data['status']), function ($query) use ($data) {
            return $query->where('status', $data['status']);
        })->when(isset($data['priority']), function ($query) use ($data) {
            return $query->where('priority', $data['priority']);
        })->when(isset($data['search']), function ($query) use ($data) {
            return $query->where('title', 'like', '%'.$data['search'].'%');
        });

        // Sorting
        if (isset($data['sort']) && $data['sort'] === 'due_date') {
            $query->orderBy('due_date', 'desc');
        } elseif (isset($data['sort']) && $data['sort'] === 'priority') {
            $query->orderByRaw("
                CASE 
                    WHEN priority = 'high' THEN 1
                    WHEN priority = 'medium' THEN 2
                    WHEN priority = 'low' THEN 3
                END ASC
            ");
        } else {
            // Smart default sorting
            $query->orderByRaw("
                CASE 
                    WHEN priority = 'high' THEN 1
                    WHEN priority = 'medium' THEN 2
                    WHEN priority = 'low' THEN 3
                END ASC
            ")->orderBy('due_date', 'asc');
        }

        return $query->get();
    }

    public function store(array $data)
    {
        return Task::create($data);
    }

    public function update(array $data, Task $task)
    {
         
        $user = Auth::user();

        if (! $user->hasRole('admin')) {
            $data = ['status' => $data['status'] ?? $task->status];
        }

        $newStatus = $data['status'] ?? $task->status;

        if ($task->status === 'done' && $newStatus !== 'done') {
            throw new TaskStatusException('Task is already done and cannot be changed');
        }

        if ($task->status === 'pending' && $newStatus === 'done') {
            throw new TaskStatusException('Task must go through in_progress first');
        }

        if ($task->status === 'in_progress' && $newStatus === 'pending') {
            throw new TaskStatusException('Cannot move back to pending');
        }

        $task->update($data);

        return $task->fresh();
    }

    public function destroy(Task $task)
    {
        return $task->delete();
    }

    public function find($task_id)
    {
        return Task::findOrFail($task_id);
    }
}
