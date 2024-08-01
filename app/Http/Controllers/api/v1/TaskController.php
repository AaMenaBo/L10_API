<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function index()
    {
        return TaskResource::collection(Task::all());
    }
    public function show()
    {
        return TaskResource::collection(auth()->user()->tasks);
    }
    public function update(Request $request, Task $task)
    {
        if (!Gate::authorize('update', $task)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $data = $request->validate([
            'name' => 'required',
        ]);
        $task->update([
            'name' => $data['name'],
        ]);
        return new TaskResource($task);
    }
    public function destroy(Task $task)
    {
        if (!Gate::authorize('delete', $task)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }
}
