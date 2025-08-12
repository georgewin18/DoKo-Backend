<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskGroup;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json(Task::with('taskGroup')->get());
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

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    public function show($id)
    {
        return response()->json(Task::with('taskGroup')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'description' => 'nullable|string',
            'attachment' => 'nullable|string',
            'date' => 'sometimes|date',
            'time' => 'sometimes',
            'progress' => 'sometimes|integer|min:0|max:100',
            'task_group_id' => 'sometimes|exists:task_group,id',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
