<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SubordinateUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        // Get the authenticated user
        $user = $request->user();

        // Load the children (subordinate users) relationship
        // You can also add pagination
        $subordinates = $user->children()->paginate(10);

        return Inertia::render('Users/Index', [
            'users' => $subordinates,
        ]);
    }
}
