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
        Schema::create('admin_agent_bots', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('admin_user_id')->index();
             $table->foreign('admin_user_id', 'admin_agent_bots_admin_user_id_foreign')
              ->references('id')->on('users')->cascadeOnDelete();
             $table->text('task');
             $table->longText('result')->nullable();

             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_agent_bots');
    }
};
