<?php

use App\Http\Controllers\Halo\HaloController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/todo', function () {
    return view('todolist.app');
});

Route::get('/halo', [HaloController::class,'index']);


// Route::get('/halo', function () {
//     return view('coba.hallo');
// });