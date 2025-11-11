<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\StoreUserRequest; // 1. Import the new validation request class
use Illuminate\Http\Request; // Keep this for other methods
use Inertia\Inertia; // Import Inertia to render views
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;
    public function index()
    {
        // Authorize if the user can view a list of any users.


        $this->authorize('viewAny', User::class);

        // TODO: We will implement this later. For now, it redirects to the main user page.
        return redirect()->route('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Authorize if the user is allowed to create users.
        $this->authorize('create', User::class);

        // This line renders the Vue component for the create user form.
        return Inertia::render('Agent/Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // 2. Use the StoreUserRequest to automatically validate the incoming data
    public function store(StoreUserRequest $request)
    {
        // Authorization is still good practice, although the request class can also handle it.
        $this->authorize('create', User::class);

        // 3. Get the validated data from the request. This is now safe to use.
        $validatedData = $request->validated();

        // Create the new user as a child of the currently logged-in user.
        $request->user()->children()->create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // 4. Redirect the user back to the main list with a success message.
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Authorize if the current user can view the target user.
        $this->authorize('view', $user);

        // TODO: Implement user profile view if needed.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Authorize if the current user can update the target user.
        $this->authorize('update', $user);

        // TODO: Return the Inertia view for the edit form.
        // return Inertia::render('Admin/Users/Edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Authorize the update action.
        $this->authorize('update', $user);

        // TODO: Create and use 'UpdateUserRequest' for validation here.
        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Authorize the delete action.
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
