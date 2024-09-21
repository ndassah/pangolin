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
        Schema::create('travaux', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('status')->default('non terminé'); // Peut être 'terminé' ou 'non terminé'
            $table->foreignId('tache_id')->constrained('taches')->onDelete('cascade'); // Relation avec Tache
            $table->foreignId('stagiaire_id')->constrained('stagiaires')->onDelete('cascade'); // Relation avec Stagiaire
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travaux');
    }
};
