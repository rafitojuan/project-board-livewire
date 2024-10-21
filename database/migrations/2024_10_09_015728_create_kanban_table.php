<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Columns Table
        Schema::create('columns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('order');
            $table->timestamps();
        });

        // Tasklists Table
        Schema::create('tasklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('column_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('work_id');
            $table->string('contract_number')->nullable();
            $table->string('pengadaan')->nullable();
            $table->integer('order');
            $table->string('company')->nullable();
            $table->string('location')->nullable();
            $table->decimal('value', 15, 2)->nullable();
            $table->decimal('adendum_value', 15, 2)->nullable();
            $table->date('contract_sign')->default(now()->format('Y-m-d'));
            $table->date('started_at')->default(now()->format('Y-m-d'));
            $table->date('end_at')->nullable();
            $table->date('adendum')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tasklist Columns Table
        Schema::create('tasklist_columns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tasklist_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('order');
            $table->timestamps();
        });

        // Tasks Table
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tasklist_column_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('order');
            $table->date('started_at')->default(now()->format('Y-m-d'));
            $table->date('end_at')->nullable();
            $table->timestamps();
        });

        // Statuses Table
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('color')->nullable();
            $table->timestamps();
        });

        // Add status_id to tasklists and tasks
        Schema::table('tasklists', function (Blueprint $table) {
            $table->foreignId('status_id')->nullable()->constrained()->onDelete('set null');
            $table->index('status_id');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('status_id')->nullable()->constrained()->onDelete('set null');
            $table->index('status_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('tasklist_columns');
        Schema::dropIfExists('tasklists');
        Schema::dropIfExists('columns');
        Schema::dropIfExists('statuses');
    }
};
