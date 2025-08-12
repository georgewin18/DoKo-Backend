<?php

namespace App\Http\Controllers;

use App\Models\TaskGroup;
use Illuminate\Http\Request;

class TaskGroupController extends Controller
{
    //get task_group
    public function index()
    {
        $taskGroup = TaskGroup::with('tasks')->get();

        return response()->json($taskGroup);
    }

    //insert task_group
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $taskGroup = TaskGroup::create($validated);

        return response()->json($taskGroup, 201);
    }

    // get task_group by id
    public function show($id)
    {
        $taskGroup = TaskGroup::with('tasks')->findOrFail($id);

        return response()->json($taskGroup);
    }

    //update task_group
    public function update(Request $request, $id)
    {
        $taskGroup = TaskGroup::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'description' => 'nullable|string',
        ]);

        $taskGroup->update($validated);

        return response()->json($taskGroup);
    }

    //delete task_group
    public function destroy($id)
    {
        $taskGroup = TaskGroup::findOrFail($id);
        $taskGroup->delete();

        return response()->json(['message' => 'Task group deleted successfully']);
    }
}
