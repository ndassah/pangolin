<?php

namespace Tests\Unit;

use App\Models\Stagiaire;
use App\Models\Tache;
use App\Models\Travaux;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase; // Utilisation de la classe TestCase de Laravel

class TravauxControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
   /** @test */
// public function it_creates_new_travaux()
// {
//     $stagiaire = Stagiaire::factory()->create();
//     $tache = Tache::factory()->create();

//     $response = $this->json('POST', '/api/travaux', [
//         'nom' => 'Nouveau Travail',
//         'description' => 'Description du travail',
//         'tache_id' => $tache->id,
//         'stagiaire_id' => $stagiaire->id,
//     ]);

//     $response->assertStatus(201)
//              ->assertJsonStructure(['message', 'travail']);

//     $this->assertDatabaseHas('travaux', [
//         'nom' => 'Nouveau Travail',
//         'tache_id' => $tache->id,
//         'stagiaire_id' => $stagiaire->id,
//         'status' => 'en cours', // Statut par défaut
//     ]);
// }

//afficher les travaux
/** @test */
public function it_shows_all_travaux()
{
    // Créer quelques travaux
    $travaux = Travaux::factory()->count(3)->create();

    // Simuler la requête pour récupérer tous les travaux
    $response = $this->json('GET', '/api/travaux');

    // Vérifier que la réponse contient les travaux
    $response->assertStatus(200)
             ->assertJsonCount(3, 'travaux');
}


}
