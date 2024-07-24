<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate as Authorize;

class TaskController extends Controller
{
    public function index()
    {

        $tasks = Task::all();
        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }

    public function create()
    {

        return view('tasks.create', [
            'priorities' => Priority::all(),
            'users' => User::all(),
            'tags' => Tag::all()
        ]);
    }

    public function show(Task $task)
    {
        return view('tasks.show', [
            'task' => $task
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:3'],
            'priority_id' => 'required|exists:priorities,id',
            'user_id' => 'required|exists:users,id',
            'tags' => 'exists:tags,id'
        ]);
        $task = new Task();
        $task->name = $data['name'];
        $task->description = $data['description'];
        $task->priority_id = $data['priority_id'];
        $task->user_id = $data['user_id'];
        $task->save();
        if (isset($data['tags'])) {
            $task->tags()->sync($data['tags']);
        } else {
            $task->tags()->detach();
        }

        /*
        Task::create([
        ...$data,
        'user_id' => auth()->id(),
        ]);
        */

        return redirect('/tasks');
    }

    public function edit(Task $task)
    {

        /*
        Gate::define('update-task', function (User $user, Task $task) {
            return $user->id == $task->user_id;
        });

        
        if(!Auth::check()){
            return redirect('/login');
        }

        if($task->user->isNot(auth()->user())){
            abort(403);
        }
        */

       // Gate::authorize('update-task', $task);
       // auth()->user()->can('update-task', $task);

       Authorize::authorize('update', $task);
       
        return view('tasks.edit', [
            'task' => $task,
            'tags' => Tag::all()
        ]);


        /*
        if (auth()->user()->id != $task->user_id) {
            return redirect('/tasks');
        }
        */

    }

    public function update(Task $task)
    {
        $data = request()->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:3'],
            'tags' => ['exists:tags,id']
        ]);

        $task->name = $data['name'];
        $task->description = $data['description'];
        if (isset($data['tags'])) {
            $task->tags()->sync($data['tags']);
        } else {
            $task->tags()->detach();
        }
        $task->save();
        return redirect('/tasks/' . $task->id);
    }
    public function complete(Task $task)
    {
        $task->completed = !$task->completed;
        $task->save();
        return redirect('/tasks');
    }

    public function delete(Task $task)
    {
        $task->delete();
        return redirect('/tasks');
    }
}
