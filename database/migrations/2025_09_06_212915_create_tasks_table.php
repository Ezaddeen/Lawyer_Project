<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('user_id')->index();
           $table->foreign('user_id', 'tasks_user_id_foreign')
           ->references('id')->on('users')
            ->onDelete('cascade');
            $table->string('title', 200)->index();
            $table->enum('priority', ['High', 'Normal', 'Low'])->default('Normal')->index();
            $table->enum('status', ['Not Started', 'In Progress', 'Completed', 'Deferred', 'Waiting'])
            ->default('Not Started')->index();
            $table->integer('percent_complete')->default(0);
            $table->text('description')->nullable();
            $table->date('due_date')->nullable()->index();
            $table->dateTime('finished_at')->nullable()->index();
            $table->json('attachments')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

