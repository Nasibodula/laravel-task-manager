<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Add title column if it doesn't exist
            if (!Schema::hasColumn('tasks', 'title')) {
                $table->string('title')->after('id');
            }
            
            // Add description column if it doesn't exist
            if (!Schema::hasColumn('tasks', 'description')) {
                $table->text('description')->after('title');
            }
            
            // Add user_id column if it doesn't exist
            if (!Schema::hasColumn('tasks', 'user_id')) {
                $table->foreignId('user_id')->after('description')->constrained()->onDelete('cascade');
            }
            
            // Add status column if it doesn't exist
            if (!Schema::hasColumn('tasks', 'status')) {
                $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending')->after('user_id');
            }
            
            // Add deadline column if it doesn't exist
            if (!Schema::hasColumn('tasks', 'deadline')) {
                $table->datetime('deadline')->after('status');
            }
            
            // Add assigned_by column if it doesn't exist
            if (!Schema::hasColumn('tasks', 'assigned_by')) {
                $table->foreignId('assigned_by')->after('deadline')->constrained('users')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $columnsToCheck = ['assigned_by', 'user_id', 'deadline', 'status', 'description', 'title'];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('tasks', $column)) {
                    if (in_array($column, ['user_id', 'assigned_by'])) {
                        $table->dropForeign([$column]);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};
