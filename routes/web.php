<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ---> این بخش جدید را اضافه کنید <---
Route::get('/reports', function () {
    // نام کامپوننت Vue که در قدم سوم می‌سازیم
    return inertia('Reports/Index');
})->middleware(['auth'])->name('reports.index');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/admin/web.php';
require __DIR__.'/agent/web.php';
require __DIR__.'/adminAgent/web.php';



