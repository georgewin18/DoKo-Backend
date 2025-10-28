<?php

namespace App\Repositories;

use App\Models\FocusTimer;
use Illuminate\Database\Eloquent\Collection;

class FocusTimerRepository
{
    public function getAll(): Collection
    {
        return FocusTimer::all();
    }

    public function create(array $data): FocusTimer
    {
        return FocusTimer::create($data);
    }

    public function findOrFail(int $id): FocusTimer
    {
        return FocusTimer::findOrFail($id);
    }

    public function update(int $id, array $data): FocusTimer
    {
        $timer = FocusTimer::findOrFail($id);
        $timer->update($data);
        return $timer;
    }

    public function delete(int $id): bool
    {
        $timer = FocusTimer::findOrFail($id);
        return $timer->delete();
    }
}