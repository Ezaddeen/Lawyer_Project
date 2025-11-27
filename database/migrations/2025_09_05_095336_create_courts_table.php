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
        Schema::create('courts', function (Blueprint $table) {
            $table->id();

            $table->string('name', 200)->index();
            $table->enum('kind', ['محكمة','نيابة','قسم شرطة'])->index();
            $table->enum('level', ['ابتدائية','استئناف','عليا','غير ذالك'])->nullable()->index();
            $table->string('city', 120)->nullable()->index();
            $table->string('address', 255)->nullable();
            $table->longText('location')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courts');
    }
};

