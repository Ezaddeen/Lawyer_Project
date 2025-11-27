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
        Schema::create('case_amendments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('case_id');
            $table->foreign('case_id', 'fk_case_amendments_legal_case')
            ->references('id')->on('legal_case')->onDelete('cascade');
            $table->string('file_name')->index();
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->unsignedBigInteger('modified_by');
            $table->foreign('modified_by', 'fk_case_amendments_users')
            ->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('modified_at')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_amendments');
    }
};
