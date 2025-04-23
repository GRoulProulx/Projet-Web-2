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
        Schema::create('cellar_bottles_has_cellars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cellar_id');
            $table->unsignedBigInteger('cellar_bottle_id');
            $table->timestamps();

            $table->foreign('cellar_id')->references('id')->on('cellars')->onDelete('cascade');
            $table->foreign('cellar_bottle_id')->references('id')->on('cellar_bottles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cellar_bottles_has_cellars');
    }
};
