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
        Schema::create('lawyers', function (Blueprint $table) {
            $table->id();
            $table->string("name", 150)->index();
            $table->enum("grade", ['تحت التمرين', 'ابتدائي', 'استئناف', 'عليا'])->nullable()->index();
            $table->string("city", 120)->nullable()->index();
            $table->string("address", 255)->nullable();
            $table->string("email", 150)->unique();
            $table->string("username", 120)->unique();
            $table->string("password", 255)->nullable();
            $table->string("phone")->nullable()->index();
            $table->date("joined_at")->nullable()->index();
            $table->date("end_at")->nullable()->index();
            $table->text("note")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyers');
    }
};
