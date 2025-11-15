<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            // مسیرهای اصلی وب سایت شما را ثبت می‌کند
            Route::middleware('web') // <-- گروه اصلی میدلور
                ->group(base_path('routes/web.php'));

            // مسیرهای ادمین
            Route::middleware('web') // <-- ابتدا گروه اصلی web را اعمال می‌کنیم
                ->group(function() { // <-- سپس یک گروه جدید باز می‌کنیم
                    Route::middleware(['auth', 'role:admin']) // <-- میدلورهای اضافی در این گروه داخلی
                        ->prefix('admin')
                        ->name('admin.')
                        ->group(base_path('routes/admin.php'));
                });
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
