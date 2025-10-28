<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FocusTimerRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FocusTimerController extends Controller
{
    protected $repository;

    public function __construct(FocusTimerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json($this->repository->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:focus_timer,name', // Validasi unik
            'focus_time' => 'required|integer|min:1',
            'break_time' => 'required|integer|min:1',
            'section' => 'required|integer|min:1',
        ]);

        $timer = $this->repository->create($validated);
        return response()->json($timer, 201);
    }

    public function show($id)
    {
        try {
            $timer = $this->repository->findOrFail($id);
            return response()->json($timer);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Timer not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|unique:focus_timer,name,' . $id, // Validasi unik (abaikan diri sendiri)
            'focus_time' => 'sometimes|integer|min:1',
            'break_time' => 'sometimes|integer|min:1',
            'section' => 'sometimes|integer|min:1',
        ]);

        try {
            $timer = $this->repository->update($id, $validated);
            return response()->json($timer);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Timer not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json(['message' => 'Timer deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Timer not found'], 404);
        }
    }
}
