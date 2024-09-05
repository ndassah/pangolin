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
        Schema::create('notations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stagiaire_id')->constrained('stagiaires')->onDelete('cascade');
            $table->foreignId('tache_id')->constrained('taches')->onDelete('cascade');
            $table->foreignId('superviseur_id')->nullable()->constrained('superviseurs')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('administrateurs')->onDelete('cascade');
            $table->integer('note');
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notations');
    }
};
