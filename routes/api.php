<?php

use App\Http\Controllers\ActiviteeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\registerController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\SuperviseurController;
use App\Http\Controllers\TacheController;
use Illuminate\Support\Facades\Route;     

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register',[registerController::class,'register'])->name('api.register');


Route::controller(loginController::class)->group(function(){

    Route::post('login','login')->name('api.login');
    Route::Post('/reset/otp','resetOtp')->name('api.reset.otp');
    Route::Post('/reset/password','resetPassword')->name('api.reset.password');

    Route::middleware('auth:sanctum')->group(function(){
        Route::post('otp','otp')->name('api.otp');
        Route::post('verify','verify')->name('api.otp.verify'); 
    });
});



// admin role routes
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/admin/data', [AdminController::class, 'index']);
});

//superviseur role routes
Route::middleware(['auth:api', 'role:superviseur'])->group(function () {
    Route::get('/superviseur/data', [SuperviseurController::class, 'index']);
});


//stagiaire role routes
Route::middleware(['auth:api', 'role:stagiaire'])->group(function () {
    Route::get('/stagiaire/data', [StagiaireController::class, 'index']);
});

//stage routes
Route::post('stage/create', [StageController::class,'store']);
Route::get('stage/all',[StageController::class,'index']);

//stagiaire
Route::post('stagiaire/create', [StagiaireController::class,'store']);
Route::get('stagiaire/all',[StagiaireController::class,'index']);
Route::post('stagiaire/update/{id}', [StagiaireController::class,'update']);

//direction
Route::post('direction/create', [DirectionController::class,'store']);
Route::get('direction/all', [DirectionController::class,'index']);
Route::post('direction/update/{id}', [DirectionController::class,'update']);

//service
Route::post('service/create', [ServiceController::class,'store']);
Route::get('service/all', [ServiceController::class,'index']);
Route::post('service/update/{id}', [ServiceController::class,'update']);

//superiseur
Route::post('superviseur/create', [SuperviseurController::class,'store']);
Route::get('superviseur/all',[SuperviseurController::class,'index']);
Route::post('superviseur/update/{id}', [SuperviseurController::class,'update']);

//activites
Route::post('activites/create', [ActiviteeController::class,'store']);
Route::get('activites/all', [ActiviteeController::class,'index']);
Route::post('activites/update/{id}', [ActiviteeController::class,'update']);

//tache
Route::post('taches/creer', [TacheController::class, 'creerEtAttribuerTache']);
Route::post('taches/{id}/terminer', [TacheController::class, 'terminerTache']);
Route::post('taches/{id}/valider', [TacheController::class, 'validerTache']);

//evaluation
Route::get('stagiaires/{id}/evaluer', [EvaluationController::class, 'evaluerStagiaire']);
Route::get('/evaluation/{stagiaire_id}/rapport', [EvaluationController::class, 'imprimerRapportEvaluation']);


//utilisateur
Route::get('users/all', [registerController::class,'index']);

