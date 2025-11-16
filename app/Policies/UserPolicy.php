<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     * (Only admins can see the user list)
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update a user's role/info.
     * (Only admins can update user info)
     */
    public function update(User $user, User $model): bool
    {
        // Only an admin can update a user
        if ($user->role === 'admin') {
            // Prevent admin from accidentally changing their own role to non-admin
            if ($user->id === $model->id && $model->isDirty('role') && $model->role !== 'admin') {
                return false;
            }
            return true;
        }
        return false;
    }
}