<?php

use App\Http\Controllers\Agent\SubordinateUsersController;
use App\Http\Controllers\Agent\UserController as AgentUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- Routes for Agent ---
// تمام میدلورها، پیشوندها و نام‌ها از فایل bootstrap/app.php اعمال می‌شوند

// داشبورد نماینده
// URL نهایی: /agent/dashboard
// نام نهایی روت: agent.dashboard
Route::get('/dashboard', fn() => Inertia::render('Agent/Dashboard'))->name('dashboard');


// مدیریت کاربران زیرمجموعه نماینده
// URL نهایی: /agent/users
// نام نهایی روت: agent.users.index
Route::get('/users', [SubordinateUsersController::class, 'index'])->name('users.index');
Route::get('/users/create', [AgentUserController::class, 'create'])->name('users.create');
Route::post('/users', [AgentUserController::class, 'store'])->name('users.store');
