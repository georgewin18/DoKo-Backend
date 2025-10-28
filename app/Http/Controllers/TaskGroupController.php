<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaskGroupRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskGroupController extends Controller
{
    protected $repository;

    public function __construct(TaskGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    // get task_group
    public function index()
    {
        $taskGroup = $this->repository->getAllWithTasks();
        return response()->json($taskGroup);
    }

    // insert task_group
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $taskGroup = $this->repository->create($validated);

        return response()->json($taskGroup, 201);
    }

    // get task_group by id
    public function show($id)
    {
        try {
            $taskGroup = $this->repository->findOrFailWithTasks($id);
            return response()->json($taskGroup);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task group not found'], 404);
        }
    }

    // update task_group
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'description' => 'nullable|string',
        ]);

        try {
            $taskGroup = $this->repository->update($id, $validated);
            return response()->json($taskGroup);
        } catch (ModelNotFoundExeption $e) {
            return response()->json(['message' => 'Task group not found'], 404);
        }
    }

    //delete task_group
    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json(['message' => 'Task group deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task group not found'], 404);
        }
    }
}
