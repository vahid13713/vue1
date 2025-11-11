<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Perform pre-authorization checks.
     * This grants the 'admin' role full access to all actions.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        // Return null to allow other policy methods to run.
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // An agent should be able to see the user list page.
        return $user->role === 'agent';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $targetUser): bool
    {
        // An agent can only view their own subordinate users.
        return $targetUser->parent_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // An agent can create new users (who will become their subordinates).
        return $user->role === 'agent';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $targetUser): bool
    {
        // An agent can only update their own subordinate users.
        return $targetUser->parent_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $targetUser): bool
    {
        // The logic is the same as updating.
        return $this->update($user, $targetUser);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $targetUser): bool
    {
        // The logic is the same as updating.
        return $this->update($user, $targetUser);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $targetUser): bool
    {
        // The logic is the same as updating.
        return $this->update($user, $targetUser);
    }
}
