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
        Schema::create('client_contacts', function (Blueprint $table) {
               $table->id();
            $table->unsignedBigInteger('client_id')->index();
            $table->foreign('client_id', 'client_contacts_client_id_fk')
            ->references('id')->on('clients')->onDelete('cascade');
            $table->enum('type', ['email', 'phone', 'address'])->index();
            $table->string('value', 500)->index();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_contacts');
    }
};
