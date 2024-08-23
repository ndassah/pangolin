<?php

use App\Http\Controllers\ActiviteeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\registerController;
use App\Http\Controllers\DirectionController;
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
Route::post('create_stage', [StageController::class,'store']);

//stagiaire
Route::post('create_stagiaire', [StagiaireController::class,'store']);

//direction
Route::post('create_direction', [DirectionController::class,'store']);

//service
Route::post('create_service', [ServiceController::class,'store']);

//superiseur
Route::post('create_superviseur', [SuperviseurController::class,'store']);

//activites
Route::post('create_activites', [ActiviteeController::class,'store']);

//tache
Route::post('create_tache', [TacheController::class,'store']);

