<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\AuthController;

Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::patch('/students/{id}', [StudentController::class, 'updatePartial']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);





Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');








// Public routes
Route::post('/register', [AuthController::class,'register']);

Route::post('/login', [AuthController::class,'login']);
Route::get('/personajes', [AuthController::class,'getPersonajes']);
Route::get('/personajes/{id}', [AuthController::class,'getPersonaje']);

// Protected routes
Route::middleware([IsUserAuth::class])->group(function () {
    Route::post(('logout'), [AuthController::class,'logout']);
    Route::get('me', [AuthController::class,'getUser']);
});


// Admin routes

Route::middleware([IsAdmin::class])->group(function () {
   Route::get('users', [AuthController::class,'getUsers']);
    Route::get('users/{id}', [AuthController::class,'getUser']);
    Route::put('users/{id}', [AuthController::class,'updateUser']);
    Route::delete('users/{id}', [AuthController::class,'deleteUser']);

    Route::post('personajes', [AuthController::class,'addPersonaje']);
    Route::put('personajes/{id}', [AuthController::class,'updatePersonaje']);
    Route::delete('personajes/{id}', [AuthController::class,'deletePersonaje']);
    Route::get('personajes', [AuthController::class,'getPersonajes']);
    Route::get('personajes/{id}', [AuthController::class,'getPersonaje']);
});
