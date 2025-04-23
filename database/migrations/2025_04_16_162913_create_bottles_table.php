<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
    * Run the migrations.
    * Création de la table 'bottles' avec details provenants de la SAQ et ajout des index
    * @return void
    */

    public function up(): void
    {
        Schema::create('bottles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('type')->nullable();
            $table->string('format')->nullable();
            $table->string('country')->nullable();
            $table->string('code_saq')->unique();
            $table->string('url')->nullable();

            // Index pour optimisations des filtres 
            $table->index('type');
            $table->index('country');
    
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    
    public function down(): void
    {
        Schema::dropIfExists('bottles');
    }
};
