<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\BookLoanController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;

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


Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('register','register');
});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/logout',[AuthController::class,'logout']);
    Route::get('/auth/user',[AuthController::class,'user']);
});

//Route::apiResource('role',RoleController::class);
Route::apiResources([
    'permission'=>PermissionController::class,
    'book'=>BookController::class,
    'bookLoans'=>BookLoanController::class,
]);

//Role routes

//User Routes
Route::get('/user',[UserController::class,'index'])->name('user.index');
Route::get('/user/{user}',[UserController::class,'show'])->name('user.show');
Route::post('/user',[UserController::class,'store'])->name('user.store');
Route::put('/user/{user}',[UserController::class,'update'])->name('user.update');
Route::delete('/user/{user}',[UserController::class,'destroy'])->name('user.delete');

//Role Routes
Route::get('/role',[RoleController::class,'index'])->name('role.index');
Route::get('/role/{role}',[RoleController::class,'show'])->name('role.show');
Route::post('/role',[RoleController::class,'store'])->name('role.store');
Route::put('/role/{role}',[RoleController::class,'update'])->name('role.update');
Route::delete('/role/{role}',[RoleController::class,'destroy'])->name('role.delete');

//Routes for bookloans



