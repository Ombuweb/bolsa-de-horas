<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'time_spent_on_hours' => 'required|integer',
            'time_spent_on_minutes' => 'required|integer',
            'time_spent_on_secs' => 'required|integer',
             'description' => 'required|string',
             'project_id' => 'required|integer'
        ]);
        $task = Task::create($request->except('_token'));
        return redirect('/tasks/' . $task->id);
    }
    public function update(Request $request, Task $task)
    {
        $task->update($request->except('_token'));
    }
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/tasks');
    }
}
