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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_stagiaire')->constrained('stagiaires')->onDelete('cascade');
            $table->foreignId('id_superviseur')->constrained('superviseurs')->onDelete('cascade');
            $table->float('qualite_travail');
            $table->float('productivite');
            $table->float('aptitude');
            $table->float('engagement');
            $table->text('commentaires');
            $table->float('note_global');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
