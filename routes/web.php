<?php

use App\Http\Controllers\Halo\HaloController;
use App\Http\Controllers\Todo\TodoController;
use Illuminate\Support\Facades\Route;

// Rute untuk halaman utama yang menampilkan view 'welcome'
Route::get('/', function () {
    return view('welcome');
});

// Rute yang dikomentari: sebelumnya ada rute untuk menampilkan halaman 'todo', bisa diaktifkan jika diperlukan
// Route::get('/todo', function () {
//     return view('todo');
// });

// Rute untuk menampilkan halaman 'halo' dengan controller HaloController
// Route::get('/halo', [HaloController::class,'index']);

// Rute untuk daftar tugas (todo)
Route::get('/todo', [TodoController::class, 'index'])->name('todo');

// Rute untuk menyimpan tugas baru
Route::post('/todo', [TodoController::class, 'store'])->name('todo.post');

// Rute untuk memperbarui tugas yang ada
Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update');

// Rute untuk menghapus tugas yang ada
Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');