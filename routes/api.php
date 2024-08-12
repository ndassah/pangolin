<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response([
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'roles' => ['admin', 'user']
    ],200);
});

Route::post('register',[registerController::class,'register']);

Route::get('/ok',function(){
    //$createAdmin = Role::create(['name'=>'administrateur']);
    //$createUser = Role::create(['name'=>'stagiaire']);

    $roleAdmin = Role::find(1);
    $roleAdmin->givePermissionTo("all permissions");
});