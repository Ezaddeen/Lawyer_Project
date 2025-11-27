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
        Schema::create('daily_reports', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('case_id')->nullable()->index();
          $table->foreign('case_id', 'daily_reports_case_id_foreign')
          ->references('id')->on('legal_case')
          ->onDelete('cascade');
          $table->unsignedBigInteger('lawyer_id')->index();
          $table->foreign('lawyer_id', 'daily_reports_lawyer_id_foreign')
          ->references('id')->on('lawyers')->onDelete('cascade');
          $table->date('report_date')->index();
          $table->text('content');
          $table->tinyInteger('week_no')->nullable()->index();
          $table->enum('status', ['مكتمل', 'قيد المراجعة', 'مرفوض'])->default('قيد المراجعة')->index();
          $table->unsignedBigInteger('reviewer_id')->nullable()->index();
          $table->foreign('reviewer_id', 'daily_reports_reviewer_id_foreign')
          ->references('id')->on('users')->nullOnDelete();
          
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
