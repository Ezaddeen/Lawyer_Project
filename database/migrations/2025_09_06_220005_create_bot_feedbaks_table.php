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
        Schema::create('bot_feedbaks', function (Blueprint $table) {
            $table->id();
            $table->enum('bot_kind', ['LegalAssistant', 'AdminAgent'])->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->foreign('user_id', 'bot_feedbaks_user_id_foreign')
             ->references('id')->on('users')->nullOnDelete();
            $table->tinyInteger('rating')->index();
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_feedbaks');
    }
};


