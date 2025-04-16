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
        Schema::create('cellars', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date')->nullable();
            $table->string('storage_until')->nullable();
            $table->string('notes')->nullable();
            $table->float('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('vintage')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cellars');
    }
};
