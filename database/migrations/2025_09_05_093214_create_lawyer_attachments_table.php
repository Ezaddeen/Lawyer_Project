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
        Schema::create('lawyer_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lawyer_id')->nullable()->index();
            $table->foreign('lawyer_id', 'lawyer_attachments_lawyer_id_foreign')
            ->references('id')->on('lawyers')->onDelete('cascade');
            $table->string('file_name', 255);
            $table->string('file_path', 512)->nullable();
            $table->enum('category', ['إنابة', 'بطاقة نقابة', 'هوية', 'اخرى']);
            $table->enum('storage_type', ['DB', 'Path'])->default('Path');
            $table->binary('file_blob')->nullable();
            $table->dateTime('uploaded_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_attachments');
    }
};
