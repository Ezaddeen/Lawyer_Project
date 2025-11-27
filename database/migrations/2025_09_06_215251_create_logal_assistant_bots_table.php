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
        Schema::create('logal_assistant_bots', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('user_id')->nullable()->index();
             $table->foreign('user_id', 'logal_assistant_bots_user_id_foreign')
              ->references('id')->on('users')->nullOnDelete();
             $table->text('question');
             $table->longText('response')->nullable();
             $table->unsignedBigInteger('source_law_id')->nullable()->index();
             $table->foreign('source_law_id', 'logal_assistant_bots_source_law_id_foreign')
              ->references('id') ->on('laws_documents')->nullOnDelete();

             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logal_assistant_bots');
    }
};
