<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SubordinateUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        // 1. دریافت کاربر احراز هویت شده
        $user = $request->user();

        // 2. شروع کوئری از کاربران زیرمجموعه
        $subordinates = $user->children()
            // 3. اعمال فیلتر جستجو (فقط در صورتی که پارامتر 'search' وجود داشته باشد)
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            // 4. اعمال فیلتر نقش (فقط در صورتی که پارامتر 'role' وجود داشته باشد)
            ->when($request->input('role'), function ($query, $role) {
                $query->where('role', $role);
            })
            // 5. صفحه‌بندی نتایج
            ->paginate(10)
            // 6. حفظ پارامترهای فیلتر در لینک‌های صفحه‌بندی
            ->withQueryString()
            ->through(fn ($subordinate) => [
                'id' => $subordinate->id,
                'name' => $subordinate->name,
                'email' => $subordinate->email,
                'role' => $subordinate->role,
                'created_at' => $subordinate->created_at,
            ]);

        // 7. ارسال داده‌ها و فیلترهای فعال به کامپوننت ویو
        return Inertia::render('Users/Index', [
            'users' => $subordinates,
            'filters' => $request->only(['search', 'role']),
        ]);
    }
}
