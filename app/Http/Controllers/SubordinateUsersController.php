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
        // 1. Get the authenticated user
        $user = $request->user();

        // 2. Start the query from the subordinate users
        $subordinates = $user->children()
            // 3. Apply search filter (only if the 'search' parameter exists)
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            // 4. Apply role filter (only if the 'role' parameter exists)
            ->when($request->input('role'), function ($query, $role) {
                $query->where('role', $role);
            })
            // 5. Paginate the results
            ->paginate(10)
            // 6. Preserve filter parameters in pagination links
            ->withQueryString()
            ->through(fn ($subordinate) => [
                'id' => $subordinate->id,
                'name' => $subordinate->name,
                'email' => $subordinate->email,
                'role' => $subordinate->role,
                'created_at' => $subordinate->created_at,
            ]);

        // 7. Send data and active filters to the view component
        return Inertia::render('Users/Index', [
            'users' => $subordinates,
            'filters' => $request->only(['search', 'role']),
        ]);
    }
}
