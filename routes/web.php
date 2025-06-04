<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JocController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('/jocs');
});

// Rutas resource para jocs
Route::resource('jocs', JocController::class);
