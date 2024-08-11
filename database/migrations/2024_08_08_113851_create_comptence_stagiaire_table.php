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
        Schema::create('comptence_stagiaire', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competence_id')->constrained('competences')->onDelete('cascade');
            $table->foreignId('id_stagiaire')->constrained('stagiaires')->onDelete('cascade');
            //$table->primary(['competence_id','id_stagiaire']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptence_stagiaire');
    }
};
