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
        Schema::create('court_changes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('court_id')->nullable()->index();
            $table->foreign('court_id', 'court_changes_court_id_foreign')
            ->references('id')->on('courts')->onDelete('cascade');
            $table->string('old_location', 255)->nullable();
            $table->string('new_location', 255)->nullable();
            $table->unsignedBigInteger('modifed_by')->nullable()->index();
            $table->foreign('modifed_by', 'court_changes_modified_by_foreign')
            ->references('id')->on('users')->onDelete('cascade');
            $table->date('change_date');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('court_changes');
    }
};
