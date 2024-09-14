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
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->integer('duree_prevue');
            $table->integer('duree_effective')->nullable();
            $table->string('status')->default('en cours');
            $table->decimal('pourcentage', 5, 2)->default(0);
            $table->text('feedback')->nullable();
            $table->integer('note')->nullable();
            $table->boolean('validation_superviseur')->default(false);
            $table->foreignId('activite_id')->constrained('activites')->onDelete('cascade'); // Relation avec Activite
            $table->foreignId('id_superviseur')->constrained('superviseurs')->onDelete('cascade'); // Relation avec Superviseur
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
