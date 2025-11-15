<?php

use App\Http\Controllers\Agent\SubordinateUsersController;
use App\Http\Controllers\Agent\UserController as AgentUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- Routes for Agent role ONLY ---
Route::middleware(['auth', 'role:admin'])
    ->group(function () {

        // داشبورد نماینده
        Route::get('admin/dashboard', fn() => Inertia::render('Admin/Dashboard'))->name('admin.dashboard');


        // مدیریت کاربران زیرمجموعه نماینده
        Route::get('admin/users', [SubordinateUsersController::class, 'index'])->name('admin.users.index');
        Route::get('admin/users/create', [AgentUserController::class, 'create'])->name('admin.users.create');
        Route::post('admin/users', [AgentUserController::class, 'store'])->name('admin.users.store');
    });
