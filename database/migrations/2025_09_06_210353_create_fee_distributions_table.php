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
        Schema::create('fee_distributions', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('transaction_id')->index();
             $table->foreign('transaction_id', 'fee_distributions_transaction_id_foreign')
             ->references('id')->on('transactions')
             ->onDelete('cascade');
             $table->enum('beneficiary_type', ['محامي','مكتب','تكلفة','وكيل'])->index();
             $table->integer('beneficiary_id')->nullable()->index();
             $table->enum('rule_type', ['جلب عميل','حضور جلسة','إعداد عرائض','تكاليف','نسبة المكتب'])->index();
             $table->double('percentage', 5, 2)->nullable()->index();
             $table->double('amount', 12, 2)->index();

             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_distributions');
    }
};
