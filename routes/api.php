<?php

use App\Http\Controllers\activiteController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\registerController;
use App\Http\Controllers\directionController;
use App\Http\Controllers\serviceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use spatie\permission\Models\Role;
use spatie\permission\Models\Permission;

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


Route::post('direction',[directionController::class,'create'])->name('direction.create');

Route::post('service',[serviceController::class,'create'])->name('service.create');

Route::post('activites',[activiteController::class,'create'])->name('activite.create');
