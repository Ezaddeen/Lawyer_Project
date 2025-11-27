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
        Schema::create('revenue_distribution_rules', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('lawyer_id')->nullable()->index();
          $table->foreign('lawyer_id', 'revenue_distribution_rules_lawyer_id_foreign')
          ->references('id')->on('lawyers')->onDelete('cascade');
          $table->unsignedBigInteger('case_id')->nullable()->index();
          $table->foreign('case_id', 'revenue_distribution_rules_case_id_foreign')
          ->references('id')->on('legal_case') // ⚠ تأكد من أن اسم الجدول عندك هو legal_case مش legal_cases
          ->onDelete('cascade');
          $table->enum('type', ['جلب عميل','حضور جلسة','إعداد عرائض','تكاليف','نسبة المكتب'])->index();
          $table->double('percentage', 5, 2)->nullable()->index();
          $table->double('amount', 12, 2)->nullable()->index();
          $table->date('effective_from')->nullable()->index();
          $table->date('effective_to')->nullable()->index();
          
          $table->timestamps();

          $table->index(['lawyer_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenue_distribution_rules');
    }
};
