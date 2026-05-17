<?php

namespace App\Services;

use App\Contracts\TaskRepoInterface;

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

    public function update(array $data, $task_id)
    {
        return $this->repo->update($data, $task_id);
    }

    public function destroy($task_id)
    {
        return $this->repo->destroy($task_id);
    }

    public function show($task_id)
    {
        return $this->repo->show($task_id);
    }
}
