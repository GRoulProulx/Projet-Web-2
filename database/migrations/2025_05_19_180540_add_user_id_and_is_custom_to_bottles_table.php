<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Ajoute les colonnes `user_id` et `is_custom` à la table `bottles`.
     */
    public function up(): void
    {
        Schema::table('bottles', function (Blueprint $table) {
            // Colonne pour identifier l'utilisateur créateur (nullable pour les bouteilles SAQ)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // Colonne booléenne pour identifier les bouteilles personnalisées
            $table->boolean('is_custom')->default(false);
        });
    }

    /**
     * Supprime les colonnes ajoutées.
     */
    public function down(): void
    {
        Schema::table('bottles', function (Blueprint $table) {
            // Supprimer la clé étrangère avant la colonne
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'is_custom']);
        });
    }
};
