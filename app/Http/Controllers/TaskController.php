<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    protected $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json($this->repository->getAllWithGroup());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'attachment' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'progress' => 'sometimes|integer|min:0|max:100',
            'task_group_id' => 'required|exists:task_group,id',
        ]);

        if (!isset($validated['progress'])) {
            $validated['progress'] = 0;
        }

        $task = $this->repository->create($validated);

        return response()->json($task, 201);
    }

    public function show($id)
    {
        try {
            $task = $this->repository->findOrFailWithGroup($id);
            return response()->json($task);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'description' => 'nullable|string',
            'attachment' => 'nullable|string',
            'date' => 'sometimes|date',
            'time' => 'sometimes',
            'progress' => 'sometimes|integer|min:0|max:100',
            'task_group_id' => 'sometimes|exists:task_group,id',
        ]);

        try {
            $task = $this->repository->update($id, $validated);
            return response()->json($task);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json(['message' => 'Task deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }
}
