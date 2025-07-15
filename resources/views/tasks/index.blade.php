@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>My Tasks</h1>
        <p class="text-muted">Tasks assigned to you</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Deadline</th>
                        <th>Assigned By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr class="{{ $task->deadline->isPast() && $task->status !== 'completed' ? 'table-warning' : '' }}">
                            <td>
                                <strong>{{ $task->title }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $task->status_color }} status-badge">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td>
                                {{ $task->deadline->format('M d, Y H:i') }}
                                @if($task->deadline->isPast() && $task->status !== 'completed')
                                    <br><span class="badge bg-danger">Overdue</span>
                                @endif
                            </td>
                            <td>{{ $task->assignedBy->name }}</td>
                            <td>
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                
                                @if($task->status !== 'completed')
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-success dropdown-toggle" 
                                                data-bs-toggle="dropdown">
                                            <i class="fas fa-edit"></i> Update Status
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if($task->status !== 'pending')
                                                <li>
                                                    <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="pending">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-clock text-warning"></i> Pending
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            
                                            @if($task->status !== 'in_progress')
                                                <li>
                                                    <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="in_progress">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-play text-info"></i> In Progress
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            
                                            <li>
                                                <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-check text-success"></i> Completed
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="py-4">
                                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No tasks assigned to you yet.</p>
                                </div>
                            </td>
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
@endsection