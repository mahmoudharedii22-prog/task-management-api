<?php

namespace App\Contracts;

interface TaskRepoInterface
{
    public function index(array $data);

    public function store(array $data);

    public function update(array $data, $task_id);

    public function destroy($task_id);

    public function show($task_id);
}
