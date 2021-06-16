<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $this->authorize('view-all-tasks', Task::class);
        return view('tasks', Task::all());
    }
    public function create(Project $project)
    {
        return view('admin.tasks.create', ['project' => $project]);
    }
    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $validated = $request->validate([
            'time_spent_on_hours' => 'required|integer|min:0',
            'time_spent_on_minutes' => 'required|integer|min:0|max:59',
            'time_spent_on_secs' => 'required|integer|min:0|max:59',
            'description' => 'required|string',
            'project_id' => 'required|integer'
        ]);

        $time = $validated['time_spent_on_hours'] *  3600 + $validated['time_spent_on_minutes'] * 60 + $validated['time_spent_on_secs'];
        $task = Task::create([
            'time_spent_on_secs' => $time,
            'description' => $validated['description'],
            'project_id' => $validated['project_id']
        ]);

        return redirect('/tasks/' . $task->id);
    }
    public function edit(Task $task)
    {
        $seconds = $task->time_spent_on_secs;
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);
        return view('admin.tasks.update', ['task' => $task, 'hours' => $hours, 'minutes' => $mins, 'secs' => $secs]);
    }
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', Task::class);
        $validated = $request->validate([
            'time_spent_on_hours' => 'required|integer|min:0',
            'time_spent_on_minutes' => 'required|integer|min:0|max:59',
            'time_spent_on_secs' => 'required|integer|min:0|max:59',
            'description' => 'required|string',
            'project_id' => 'required|integer'
        ]);
        
        $time = $validated['time_spent_on_hours'] *  3600 + $validated['time_spent_on_minutes'] * 60 + $validated['time_spent_on_secs'];
        //dd($time);
        $task->update([
            'time_spent_on_secs' => $time,
            'description' => $validated['description'],
            'project_id' => $validated['project_id']
        ]);
        return redirect('/tasks/' . $task->id);
    }

    public function show(Task $task)
    {
        return view('admin.tasks.show', ['task' => $task]);
    }
    public function destroy(Task $task)
    {
        $this->authorize('delete', Task::class);

        $task->delete();
        return redirect('/projects/' .$task->project->slug);
    }
}
