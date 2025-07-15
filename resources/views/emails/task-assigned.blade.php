<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .task-details {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #007bff;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Task Assigned</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $task->user->name }},</p>
            
            <p>You have been assigned a new task. Please find the details below:</p>
            
            <div class="task-details">
                <h3>{{ $task->title }}</h3>
                <p><strong>Description:</strong> {{ $task->description }}</p>
                <p><strong>Deadline:</strong> {{ $task->deadline->format('M d, Y H:i') }}</p>
                <p><strong>Assigned by:</strong> {{ $task->assignedBy->name }}</p>
                <p><strong>Status:</strong> <span style="color: #ffc107;">Pending</span></p>
            </div>
            
            <p>Please log in to the system to view and update your task status.</p>
            
            <p style="text-align: center;">
                <a href="{{ route('tasks.index') }}" class="btn">View My Tasks</a>
            </p>
        </div>
        
        <div class="footer">
            <p>This is an automated email from the Task Management System.</p>
            <p>Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>