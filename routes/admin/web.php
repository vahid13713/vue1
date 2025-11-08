<?php
// مسیرهای مخصوص ادمین
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/panel', function () {
        return Inertia::render('Admin/Panel');
    })->name('panel');
});
