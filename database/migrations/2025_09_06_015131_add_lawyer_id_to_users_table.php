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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('lawyer_id')->nullable()->after('id')->index();
            $table->foreign('lawyer_id')->references('id')->on('lawyers')->onDelete('set null');
        });
    }
};
