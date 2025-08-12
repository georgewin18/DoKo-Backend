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
            'date' => 'nullable|date',
            'time' => 'nullable',
            'progress' => 'required|integer|min:0|max:100',
            'task_group_id' => 'required|exists:task_group,id',
        ]);

        $task = Task::create($validated);

        // Update counter
        $task->taskGroup->updateTaskCounts();

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
            'date' => 'nullable|date',
            'time' => 'nullable',
            'progress' => 'sometimes|integer|min:0|max:100',
            'task_group_id' => 'sometimes|exists:task_group,id',
        ]);

        $task->update($validated);

        $task->taskGroup->updateTaskCounts();

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $group = $task->taskGroup;

        $task->delete();

        // Update counter
        $group->updateTaskCounts();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
