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
        Schema::create('laws_documents', function (Blueprint $table) {
            $table->id();
            $table->string('law_number', 50)->index();
            $table->string('law_title', 255)->index();
            $table->longText('law_description')->nullable();
            $table->date('issue_date')->nullable()->index();
            $table->date('amendment_date')->nullable()->index();
            $table->string('law_category', 100)->nullable()->index();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laws_documents');
    }
};
