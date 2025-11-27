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
        Schema::create('lawyer_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lawyer_id')->nullable()->index();
            $table->foreign('lawyer_id', 'lawyer_contacts_lawyer_id_foreign')
            ->references('id')->on('lawyers')->onDelete('cascade');
            $table->enum('type', ['phone', 'email', 'address'])->index();
            $table->string('value', 255)->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_contacts');
    }
};
