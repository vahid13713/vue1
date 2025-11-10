<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SubordinateUsersController;

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


// مسیرهای مخصوص ادمین
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/panel', function () {
        return Inertia::render('Admin/Panel');
    })->name('panel');
});


// مسیرهای مخصوص نماینده
Route::middleware(['auth', 'role:agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Agent/Dashboard');
    })->name('dashboard');
});

// مسیرهایی که هم ادمین و هم نماینده به آن دسترسی دارند
Route::middleware(['auth', 'role:admin,agent'])->group(function () {
    Route::get('/my-users', [SubordinateUsersController::class, 'index'])->name('users.index');

});




