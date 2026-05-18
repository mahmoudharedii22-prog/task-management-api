<?php

namespace App\Contracts;

use App\Models\Task;

interface TaskRepoInterface
{
    public function index(array $data);

    public function store(array $data);

    public function update(array $data, Task $task);

    public function destroy(Task $task);

    public function find($task_id);
}
