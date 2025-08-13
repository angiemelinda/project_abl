<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\KonselingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama (Landing Page)
Route::view('/', 'landing')->name('home');

// Halaman daftar konseling - hanya untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/konseling', [KonselingController::class, 'list'])->name('konseling.list');
    
    // Form ajukan konseling
    Route::get('/konseling/create', [KonselingController::class, 'create'])->name('konseling.create');
    Route::post('/konseling', [KonselingController::class, 'store'])->name('konseling.store');
});

// CRUD Konseling untuk admin dan konselor
Route::middleware(['auth'])->group(function () {
    Route::get('/konseling/manage', [KonselingController::class, 'manage'])->name('konseling.manage');
    Route::get('/konseling/{id}/edit', [KonselingController::class, 'edit'])->name('konseling.edit');
    Route::put('/konseling/{id}', [KonselingController::class, 'update'])->name('konseling.update');
    Route::delete('/konseling/{id}', [KonselingController::class, 'destroy'])->name('konseling.destroy');
});

// Halaman register (GET)
Route::view('/register', 'register')->name('register');

// Proses register (POST)
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Cari role 'user' dari database
    $userRole = \App\Models\Role::where('name', 'user')->first();
    
    if (!$userRole) {
        // Jika role 'user' tidak ditemukan, jalankan seeder
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\RoleSeeder']);
        $userRole = \App\Models\Role::where('name', 'user')->first();
        
        if (!$userRole) {
            return back()->withErrors(['error' => 'Tidak dapat menemukan role user. Silakan hubungi administrator.']);
        }
    }

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $userRole->id, // Gunakan ID role 'user' dari database
    ]);

    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
})->name('register.store');

// Halaman login (GET)
Route::view('/login', 'login')->name('login');

// Proses login (POST)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        
        // Redirect berdasarkan role
        $user = Auth::user();
        if ($user->role_id == 1) { // Admin
            return redirect()->intended('/admin/dashboard');
        } else if ($user->role_id == 2) { // Konselor
            return redirect()->intended('/konselor/dashboard');
        } else { // User biasa
            return redirect()->intended('/konseling');
        }
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->withInput($request->only('email'));
})->name('login.authenticate');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    // Cek apakah user adalah admin
    if (Auth::user() && Auth::user()->role_id == 1) {
        return view('admin.dashboard');
    }
    return redirect()->route('home');
})->middleware('auth')->name('admin.dashboard');

// Admin - Manajemen User
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    
    // Manajemen Konselor
    Route::get('/konselors', [\App\Http\Controllers\UserController::class, 'konselorIndex'])->name('konselors.index');
});

// Konselor Dashboard
Route::get('/konselor/dashboard', function () {
    // Cek apakah user adalah konselor
    if (Auth::user() && Auth::user()->role_id == 2) {
        return view('konselor.dashboard');
    }
    return redirect()->route('home');
})->middleware('auth')->name('konselor.dashboard');

// Profil Pengguna
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\UserController::class, 'profile'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');
});
