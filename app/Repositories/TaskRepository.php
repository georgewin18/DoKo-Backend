<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function getAllWithGroup(): Collection
    {
        return Task::with('taskGroup')->get();
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function findOrFailWithGroup(int $id): Task
    {
        return Task::with('taskGroup')->findOrFail($id);
    }

    public function update(int $id, array $data): Task
    {
        $task = Task::findOrFail($id);
        $task->update($data);
        return $task;
    }

    public function delete(int $id): bool
    {
        $task = Task::findOrFail($id);
        return $task->delete();
    }
}