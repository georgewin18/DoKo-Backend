<?php

namespace App\Repositories;

use App\Models\TaskGroup;
use Illuminate\Database\Eloquent\Collection;

class TaskGroupRepository
{
    public function getAllWithTasks(): Collection
    {
        return TaskGroup::with('tasks')->get();
    }

    public function create(array $data): TaskGroup
    {
        return TaskGroup::create($data);
    }

    public function findOrFailWithTasks(int $id): TaskGroup
    {
        return TaskGroup::with('tasks')->findOrFail($id);
    }

    public function update(int $id, array $data): TaskGroup
    {
        $taskGroup = TaskGroup::findOrFail($id);
        
        $taskGroup->update($data);
        
        return $taskGroup;
    }

    public function delete(int $id): bool
    {
        $taskGroup = TaskGroup::findOrFail($id);

        return $taskGroup->delete();
    }
}