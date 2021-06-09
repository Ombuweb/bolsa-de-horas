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
        $time = $validated['time_spent_on_hours'] *  3600 + $validated['time_spent_on_minutes']*60 + $validated['time_spent_on_secs'];
        $task = Task::create([
            'time_spent_on_secs' => $time,
            'description' => $validated['description'],
            'project_id' => $validated['project_id']
        ]);
        return redirect('/tasks/' . $task->id);
    }
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'time_spent_on_hours' => 'required|integer',
            'time_spent_on_minutes' => 'required|integer',
            'time_spent_on_secs' => 'required|integer',
             'description' => 'required|string',
             'project_id' => 'required|integer'
        ]);
        $time = $validated['time_spent_on_hours'] *  360 + $validated['time_spent_on_minutes']*60 + $validated['time_spent_on_secs'];

        $task->update([
            'time_spent_on_secs' => $time,
            'description' => $validated['description'],
            'project_id' => $validated['project_id']
        ]);
    }
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/tasks');
    }
}
