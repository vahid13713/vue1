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
        // 1. Validate the incoming request data for security and integrity
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'role' => ['nullable', 'string', 'in:agent,user'],
            'created_from' => ['nullable', 'date_format:Y-m-d'],
            'created_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:created_from'],
        ]);

        // 2. Get the authenticated user
        $user = $request->user();

        // 3. Build the query, starting from the authorized users (children)
        $subordinates = $user->children()
            // Apply search filter if 'search' parameter exists
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            // Apply role filter if 'role' parameter exists
            ->when($request->input('role'), function ($query, $role) {
                $query->where('role', $role);
            })
            // Apply date range filter
            ->when($request->input('created_from'), function ($query, $date) {
                $query->whereDate('created_at', '>=', $date);
            })
            ->when($request->input('created_to'), function ($query, $date) {
                $query->whereDate('created_at', '<=', $date);
            })
            // 4. Paginate the results and preserve filter parameters in links
            ->paginate(10)
            ->withQueryString()
            // 5. Transform the data to prevent exposing sensitive fields
            ->through(fn ($subordinate) => [
                'id' => $subordinate->id,
                'name' => $subordinate->name,
                'email' => $subordinate->email,
                'role' => $subordinate->role,
                'created_at' => $subordinate->created_at,
            ]);

        // 6. Render the Inertia component with props
        return Inertia::render('Agent/Users/Index', [
            'users' => $subordinates,
            'filters' => $request->only(['search', 'role', 'created_from', 'created_to']),
        ]);
    }
}
