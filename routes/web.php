<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResepController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ResepController::class, 'index'])->name('home');
Route::post('/analyze', [ResepController::class, 'analyze'])->name('analyze');
Route::get('/resep/{id}', [ResepController::class, 'show'])->name('resep.show');
Route::get('/cari/{bahan}', [ResepController::class, 'searchManual'])->name('search.manual');