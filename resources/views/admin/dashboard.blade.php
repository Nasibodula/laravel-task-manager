@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Admin Dashboard</h1>
        <p class="text-muted">Welcome to the task management system admin panel</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Users</h5>
                        <h2>{{ $users }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Tasks</h5>
                        <h2>{{ $tasks }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tasks fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Pending Tasks</h5>
                        <h2>{{ $pending }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Completed Tasks</h5>
                        <h2>{{ $completed }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-2">
                    <i class="fas fa-user-plus"></i> Add New User
                </a>
                <br>
                <a href="{{ route('admin.tasks.create') }}" class="btn btn-success mb-2">
                    <i class="fas fa-plus"></i> Assign New Task
                </a>
                <br>
                <a href="{{ route('admin.users') }}" class="btn btn-info mb-2">
                    <i class="fas fa-users"></i> Manage Users
                </a>
                <br>
                <a href="{{ route('admin.tasks') }}" class="btn btn-warning">
                    <i class="fas fa-tasks"></i> Manage Tasks
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>System Overview</h5>
            </div>
            <div class="card-body">
                <p><strong>System Status:</strong> <span class="badge bg-success">Online</span></p>
                <p><strong>Active Users:</strong> {{ $users }}</p>
                <p><strong>Task Completion Rate:</strong> 
                    @if($tasks > 0)
                        {{ round(($completed / $tasks) * 100, 2) }}%
                    @else
                        0%
                    @endif
                </p>
                <p><strong>Last Updated:</strong> {{ now()->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection