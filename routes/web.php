<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KonselingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

// Rute untuk Konseling
Route::get('/konseling', [KonselingController::class, 'create'])->name('konseling.create');
Route::post('/konseling', [KonselingController::class, 'store'])->name('konseling.store');
