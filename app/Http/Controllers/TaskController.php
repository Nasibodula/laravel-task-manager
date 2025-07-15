<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tasks = auth()->user()->tasks()->with('assignedBy')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        // Make sure user can only view their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Make sure user can only update their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update(['status' => $request->status]);

        return redirect()->route('tasks.index')->with('success', 'Task status updated successfully!');
    }
}