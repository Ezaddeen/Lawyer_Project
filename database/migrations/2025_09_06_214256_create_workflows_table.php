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
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('module', 100)->index();
            $table->unsignedBigInteger('related_case_id')->nullable()->index();
            $table->foreign('related_case_id', 'workflows_related_case_id_foreign')
            ->references('id') ->on('legal_case') ->nullOnDelete();
            $table->enum('state', ['جديد', 'قيد التنفيذ', 'مكتمل', 'مؤجل'])->index();
            $table->integer('step_no')->index();
            $table->text('step_desc')->nullable();
            $table->unsignedBigInteger('assigned_user_id')->nullable()->index();
            $table->foreign('assigned_user_id', 'workflows_assigned_user_id_foreign')
            ->references('id')->on('users')->nullOnDelete();
            $table->dateTime('start_at')->nullable()->index();
            $table->dateTime('end_at')->nullable()->index();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflows');
    }
};
