<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Livewire\CategoryManager;
use App\Livewire\ProductManager;
use Illuminate\Support\Facades\Route;

// --- Rutas para usuarios no autenticados ---
Route::middleware('guest')->group(function () {
    // Registro
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// --- Rutas para usuarios autenticados ---
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Dashboard de prueba
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    //Categorías
    Route::get('/categories', CategoryManager::class)->middleware(['auth'])->name('categories');

    //Productos
    Route::get('products', ProductManager::class)->name('products');
});

// --- Redirección base ---
Route::get('/', function () {
    if (Auth::check()) {
        // Si el usuario ya ha iniciado sesión, lo redirige al dashboard.
        return redirect()->route('dashboard');
    }
    // Si no ha iniciado sesión, lo redirige a la página de login.
    return redirect()->route('login');
});
