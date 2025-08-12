<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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

// Halaman utama (Landing Page)
Route::view('/', 'landing')->name('home');

// Halaman daftar konseling terjadwal
Route::get('/konseling', function () {
    $konselings = DB::table('konseling')
        ->join('users as pengaju', 'konseling.user_id', '=', 'pengaju.id')
        ->join('users as konselor', 'konseling.konselor_id', '=', 'konselor.id')
        ->select(
            'konseling.id',
            'pengaju.name as nama_pengaju',
            'konselor.name as nama_konselor',
            'konseling.jadwal',
            'konseling.topik',
            'konseling.status'
        )
        ->where('konseling.status', 'dijadwalkan')
        ->orderBy('konseling.jadwal', 'asc')
        ->get();

    return view('konseling_list', compact('konselings'));
})->name('konseling.list');

// Form ajukan konseling
Route::get('/konseling/create', [KonselingController::class, 'create'])->name('konseling.create');
Route::post('/konseling', [KonselingController::class, 'store'])->name('konseling.store.web');

// Halaman register
Route::view('/register', 'register')->name('register');