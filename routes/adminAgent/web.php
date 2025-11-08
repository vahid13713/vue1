<?php
// مسیرهایی که هم ادمین و هم نماینده به آن دسترسی دارند
Route::middleware(['auth', 'role:admin,agent'])->group(function () {
    Route::get('/my-users', [SubordinateUsersController::class, 'index'])->name('users.index');
});
