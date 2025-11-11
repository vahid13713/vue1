<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SubordinateUsersController;
use App\Http\Controllers\Admin\UserController;

// ... Your other routes (home, dashboard, etc.) ...
Route::get('/', fn() => Inertia::render('Welcome'))->name('home');
Route::get('dashboard', fn() => Inertia::render('Dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

// --- Routes for Admin role ONLY ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/panel', fn() => Inertia::render('Admin/Panel'))->name('panel');
});

// --- Routes for Agent role ONLY ---
Route::middleware(['auth', 'role:agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Agent/Dashboard'))->name('dashboard');
});


// --- NEW: Unified User Management Routes (Accessible by both Admin and Agent) ---
Route::middleware(['auth', 'verified', 'role:admin,agent'])
    // No prefix is needed here, the URL will be simple.
    ->group(function () {

        // The URL will simply be '/users'
        Route::get('/users', [SubordinateUsersController::class, 'index'])->name('users.index');

        // The URLs will be '/users/create', '/users/{user}', etc.
        Route::resource('users', UserController::class)->except(['index']);
    });
