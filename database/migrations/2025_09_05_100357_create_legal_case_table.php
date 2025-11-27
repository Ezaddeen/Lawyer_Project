<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_case', function (Blueprint $table) {
            $table->id();
            $table->string('case_number', 100)->unique();
            $table->unsignedBigInteger('client_id')->nullable()->index();
            $table->foreign('client_id', 'legal_case_client_id_foreign')
            ->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('lawyer_id')->nullable()->index();
            $table->foreign('lawyer_id', 'legal_case_lawyer_id_foreign')
            ->references('id')->on('lawyers')->onDelete('cascade');
            $table->unsignedBigInteger('court_id')->nullable()->index();
            $table->foreign('court_id', 'legal_case_court_id_foreign')
            ->references('id')->on('courts')->onDelete('cascade');
            $table->enum('client_role', [
                'مدعي','مدعى عليه','مستأنف','مستأنف ضده',
                'طاعن','مجنى عليه','مستشكل','متظلم ضده','مقدم طلب الرد'
            ])->nullable();
            $table->string('title', 200)->nullable();
            $table->enum('category', ['جنائي','مدني','تجاري','أحوال شخصية','عمالي','أخرى'])
                  ->nullable()->index();
            $table->enum('status', [
                'قيد النظر','منتهية بحكم','معلقة','مؤجلة',
                'مغلقة','منتهية بصلح','منتهية بتنازل','متوقفة'
            ])->default('قيد النظر')->index();
            $table->date('received_at')->nullable()->index();
            $table->date('ended_at')->nullable()->index();
            $table->string('office_file_no', 100)->nullable()->index();
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_case');
    }
};
