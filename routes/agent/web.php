<?php
// مسیرهای مخصوص نماینده
Route::middleware(['auth', 'role:agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Agent/Dashboard');
    })->name('dashboard');
});
