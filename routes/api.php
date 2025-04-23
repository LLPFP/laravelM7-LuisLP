<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/students', function () { return 'Student list'; });

Route::post('/students', function () { return 'Creating student'; });

Route::put('/students/{id}', function () { return 'Updating student';
});

Route::delete('/students/{id}', function () { return 'Deleting
student'; });

Route::get('/students/{id}', function () { return 'Getting single
student'; });
