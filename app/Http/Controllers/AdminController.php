<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // $users = \App\Models\User::count();
        // return view('admin.dashboard');
        $users = \App\Models\User::count();
        $tasks = Task::count();
        $completed = Task::where('status', 'Completed')->count();
        $pending   = Task::where('status', 'Pending')->count();
        return view('admin.dashboard', compact('users', 'tasks', 'completed', 'pending'));
    }

    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $req)
    {
        $data = $req->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'role'     => 'required|in:admin,user',
            'password' => 'required|min:6',
        ]);

        $data['password'] = bcrypt($data['password']);
        User::create($data);

        return redirect()->route('admin.users');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $req, User $user)
    {
        $data = $req->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role'  => 'required|in:admin,user',
        ]);

        $user->update($data);
        return redirect()->route('admin.users');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users');
    }

    // Task management views
    public function tasks()
    {
        // $tasks = Task::with('user')->get();
        $tasks = Task::with('user')->paginate(10); 
        return view('admin.tasks.index', compact('tasks'));
    }

    public function createTask()
    {
        $users = User::where('role','user')->get();
        return view('admin.tasks.create', compact('users'));
    }

    public function storeTask(Request $req)
    {
        $data = $req->validate([
            'title'       => 'required',
            'description' => 'required',
            'deadline'    => 'required|date',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $task = Task::create($data);

        // fire email notification here if you have set it up
        // Mail::to($task->user->email)->send(new TaskAssignedNotification($task));

        return redirect()->route('admin.tasks');
    }

    public function editTask(Task $task)
    {
        $users = User::where('role','user')->get();
        return view('admin.tasks.edit', compact('task','users'));
    }

    public function updateTask(Request $req, Task $task)
    {
        $data = $req->validate([
            'title'       => 'required',
            'description' => 'required',
            'deadline'    => 'required|date',
            'status'      => 'required|in:Pending,In Progress,Completed',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $task->update($data);
        return redirect()->route('admin.tasks');
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks');
    }
}
