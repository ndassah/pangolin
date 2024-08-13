<?php

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\registerController;
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
Route::post('login',[loginController::class,'login'])->name('api.login');