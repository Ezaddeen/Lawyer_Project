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
        Schema::create('hearings', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('case_id')->nullable()->index();
           $table->foreign('case_id', 'hearings_case_id_foreign')
           ->references('id')->on('legal_case')->onDelete('cascade');
           $table->unsignedBigInteger('court_id')->nullable()->index();
           $table->foreign('court_id', 'hearings_court_id_foreign')
           ->references('id')->on('courts')->onDelete('cascade');
           $table->unsignedBigInteger('lawyer_id')->nullable()->index();
           $table->foreign('lawyer_id', 'hearings_lawyer_id_foreign')
           ->references('id')->on('lawyers')->onDelete('cascade');
           $table->unsignedBigInteger('client_id')->nullable()->index();
           $table->foreign('client_id', 'hearings_client_id_foreign')
            ->references('id')->on('clients')->onDelete('cascade');
            $table->dateTime('hearing_datetime')->index();
            $table->string('topic', 200)->nullable();
            $table->text('decision')->nullable();
            $table->text('required_action')->nullable();
            $table->date('postponed_to')->nullable()->index();
            $table->integer('conter')->nullable();
            $table->text('notes')->nullable();
            $table->string('calendar_tag')->nullable()->index();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hearings');
    }
};
