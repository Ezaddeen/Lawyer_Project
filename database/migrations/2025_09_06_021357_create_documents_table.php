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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('case_id')->nullable()->index();
            $table->foreign('case_id', 'documents_case_id_foreign')
            ->references('id')->on('legal_case')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->nullable()->index();
            $table->foreign('client_id', 'documents_client_id_foreign')
            ->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('lawyer_id')->nullable()->index();
            $table->foreign('lawyer_id', 'documents_lawyer_id_foreign')
            ->references('id')->on('lawyers')->onDelete('cascade');
            $table->string('name', 200)->index();
            $table->enum('doc_type', ['مستند', 'عريضة', 'حكم', 'محضر', 'أخرى'])->nullable()->index();
            $table->enum('storage_type', ['DB', 'Path'])->default('Path');
            $table->string('file_path', 500)->nullable();
            $table->string('file_blob')->nullable();
            $table->date('upload_at')->nullable()->index();
            $table->text('notes')->nullable();
            $table->boolean('is_missing')->default(0)->index();
            $table->boolean('in_trash')->default(false)->index();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
