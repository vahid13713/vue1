<?php

use App\Http\Controllers\Agent\SubordinateUsersController;
use App\Http\Controllers\Agent\UserController as AgentUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- Routes for Admin ---
// تمام میدلورها، پیشوندها و نام‌ها از فایل bootstrap/app.php اعمال می‌شوند

// داشبورد ادمین
// URL نهایی: /admin/dashboard
// نام نهایی روت: admin.dashboard
Route::get('/dashboard', fn() => Inertia::render('Admin/Dashboard'))->name('dashboard');

// مدیریت کاربران
// URL نهایی: /admin/users
// نام نهایی روت: admin.users.index
Route::get('/users', [SubordinateUsersController::class, 'index'])->name('users.index');
Route::get('/users/create', [AgentUserController::class, 'create'])->name('users.create');
Route::post('/users', [AgentUserController::class, 'store'])->name('users.store');
