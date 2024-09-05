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
            $table->string('description');
            $table->date('duree prevue');//en minute
            $table->date('duree effective')->nullable();// en minute
            $table->enum('status', ['en cours', 'terminee', 'echouee'])->default('en cours');
            $table->text('feedback')->nullable();
            $table->integer('note')->nullable(); // Note sur 100
            $table->boolean('validation_superviseur')->default(false);
            $table->foreignId('stagiaire_id')->nullable()->constrained('stagiaires')->onDelete('set null');
            $table->foreignId('id_activites')->constrained('activites')->onDelete('cascade');
            $table->foreignId('id_superviseur')->constrained('superviseurs')->onDelete('cascade');
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
