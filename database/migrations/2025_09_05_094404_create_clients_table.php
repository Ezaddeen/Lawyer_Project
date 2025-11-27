<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->index();
            $table->enum('type', ['شركة', 'فرد'])->index();
            $table->string('city', 120)->nullable()->index();
            $table->string('address', 255)->nullable()->index();
            $table->string('email', 150)->unique();
            $table->string('username', 120)->unique()->nullable();
            $table->string('password', 255)->nullable();
            $table->date('start_at')->nullable()->index();
            $table->date('end_at')->nullable()->index();
            $table->text('note')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
