<?php

namespace App\Services;

use App\Contracts\TaskRepoInterface;
use App\Models\Task;

class TaskService
{
    /**
     * Create a new class instance.
     */
    protected TaskRepoInterface $repo;

    public function __construct(TaskRepoInterface $repo)
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

    public function update(array $data, Task $task): Task
    {
        return $this->repo->update($data, $task);
    }

    public function destroy(Task $task): bool
    {
        return $this->repo->destroy($task);
    }

    public function find($task_id) :Task
    {
        return $this->repo->find($task_id);
    }
}
