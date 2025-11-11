<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;                  // <-- این خط را اضافه کنید
use App\Policies\UserPolicy;          // <-- این خط را اضافه کنید
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
    }
}
