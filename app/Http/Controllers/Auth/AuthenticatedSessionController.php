<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // اعتبار سنجی و دریافت کاربر
        $user = $request->validateCredentials();

        // --- حفظ منطق احراز هویت دو مرحله‌ای (مهم) ---
        if (Features::enabled(Features::twoFactorAuthentication()) && $user->hasEnabledTwoFactorAuthentication()) {
            $request->session()->put([
                'login.id' => $user->getKey(),
                'login.remember' => $request->boolean('remember'),
            ]);

            return to_route('two-factor.login');
        }
        // --- پایان منطق 2FA ---

        // ورود کاربر به سیستم
        Auth::login($user, $request->boolean('remember'));

        // ایجاد مجدد session برای امنیت
        $request->session()->regenerate();

        // --- شروع منطق جدید برای هدایت کاربر بر اساس ستون 'role' ---
        // این کد مستقیماً ستون 'role' از مدل User را می‌خواند
        $redirectRoute = match ($user->role) {
            'admin' => route('admin.dashboard'),
            'agent' => route('agent.dashboard'),
            'user'  => route('user.dashboard'),
            // یک مسیر پیش‌فرض در صورتی که نقش کاربر تعریف نشده باشد
            default => route('dashboard'), // می‌توانید این را به user.dashboard تغییر دهید
        };

        // هدایت کاربر به صفحه مورد نظر یا داشبورد مربوطه
        return redirect()->intended($redirectRoute);
        // --- پایان منطق جدید ---
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
