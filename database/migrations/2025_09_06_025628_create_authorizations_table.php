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
        Schema::create('authorizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable()->index();
            $table->foreign('client_id', 'authorizations_client_id_foreign')
            ->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('lawyer_id')->nullable()->index();
            $table->foreign('lawyer_id', 'authorizations_lawyer_id_foreign')
            ->references('id')->on('lawyers')->onDelete('cascade');
            $table->enum('type', ['خاص', 'عام'])->index();
            $table->string('company_name', 200)->nullable()->index();
            $table->date('year')->nullable()->index();
            $table->date('start_date')->nullable()->index();
            $table->date('end_date')->nullable()->index();
            $table->string('office_file_no', 100)->nullable()->index();
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
        Schema::dropIfExists('authorizations');
    }
};
