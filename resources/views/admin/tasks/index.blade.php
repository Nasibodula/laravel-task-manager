@extends('layouts.app')

@section('title', 'Manage Tasks')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Manage Tasks</h1>
            <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Assign New Task
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Deadline</th>
                        <th>Assigned By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->user->name }}</td>
                            <td>
                                <span class="badge bg-{{ $task->status_color }} status-badge">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td>
                                {{ $task->deadline->format('M d, Y H:i') }}
                                @if($task->deadline->isPast() && $task->status !== 'completed')
                                    <span class="badge bg-danger ms-1">Overdue</span>
                                @endif
                            </td>
                            <td>{{ $task->assignedBy->name }}</td>
                            <td>
                                <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.tasks.delete', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Are you sure you want to delete this task?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No tasks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $tasks->links() }}
        </div>
    </div>
</div>

<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">
    <i class="fas fa-arrow-left"></i> Back to Dashboard
</a>
@endsection