<?php

use App\Http\Controllers\Agent\SubordinateUsersController;
use App\Http\Controllers\Agent\UserController as AgentUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- Routes for Agent role ONLY ---
Route::middleware(['auth', 'role:user'])
    ->group(function () {

        // داشبوردیوزر
        Route::get('user/dashboard', fn() => Inertia::render('User/Dashboard'))->name('user.dashboard');



    });

