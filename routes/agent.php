<?php

use App\Http\Controllers\Agent\SubordinateUsersController;
use App\Http\Controllers\Agent\UserController as AgentUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- Routes for Agent role ONLY ---
Route::middleware(['auth', 'role:agent,admin'])
    ->group(function () {

        // داشبورد نماینده
        Route::get('agent/dashboard', fn() => Inertia::render('Agent/Dashboard'))->name('agent.dashboard');


        // مدیریت کاربران زیرمجموعه نماینده
        Route::get('agent/users', [SubordinateUsersController::class, 'index'])->name('agent.users.index');
        Route::get('agent/users/create', [AgentUserController::class, 'create'])->name('agent.users.create');
        Route::post('agent/users', [AgentUserController::class, 'store'])->name('agent.users.store');
    });
