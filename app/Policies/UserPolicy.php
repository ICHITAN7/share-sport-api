<?php

namespace App\Policies;
use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can update a user's role or status.
     * Only a manager can do this.
     */
    public function updateAsManager(User $loggedInUser, User $userToUpdate): bool
    {
        return $loggedInUser->rule === 'manager';
    }
}