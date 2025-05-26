<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsUserAuth;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\GamesController;
use App\Http\Controllers\CategoryController;

// Route::get('/students', [StudentController::class, 'index']);
// Route::post('/students', [StudentController::class, 'store']);
// Route::get('/students/{id}', [StudentController::class, 'show']);
// Route::put('/students/{id}', [StudentController::class, 'update']);
// Route::patch('/students/{id}', [StudentController::class, 'updatePartial']);
// Route::delete('/students/{id}', [StudentController::class, 'destroy']);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



// Public routes
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);




// Protected routes
Route::middleware([IsUserAuth::class])->group(function () {
    Route::post(('logout'), [AuthController::class,'logout']);
    Route::get('me', [AuthController::class,'getUser']);

    Route::get('/my-cards', [CardController::class, 'myCards']);
    Route::post('/cards', [CardController::class, 'store']);
    Route::get('/public-cards', [CardController::class, 'publicCards']);
    Route::delete('/cards/{id}', [CardController::class, 'destroy']);



    Route::get('/games', [GamesController::class, 'index']);
    Route::post('/games', [GamesController::class, 'store']);
    Route::put('/games/{id}', [GamesController::class, 'update']);
    Route::delete('/games/{id}', [GamesController::class, 'destroy']);
    Route::get('/games/{id}', [GamesController::class, 'show']);
    Route::get('/ranking', [GamesController::class, 'ranking']);
    Route::get('/games/user/{id}', [GamesController::class, 'getGamesByUserId']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);


});


// Admin routes

Route::middleware([IsAdmin::class])->group(function () {
   Route::get('users', [AuthController::class,'getAllUsers']);
    Route::get('users/{id}', [AuthController::class,'getUserById']);
    Route::put('users/{id}', [AuthController::class,'updateUser']);
    Route::patch('users/{id}', [AuthController::class,'updateUserPartial']);
    Route::delete('users/{id}', [AuthController::class,'deleteUser']);


    Route::get('/cards', [CardController::class, 'index']);
    Route::get('/cards/{id}', [CardController::class, 'show']);
    Route::put('/cards/{id}', [CardController::class, 'update']);
    Route::patch('/cards/{id}', [CardController::class, 'updatePartial']);
});
