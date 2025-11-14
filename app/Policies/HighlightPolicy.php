<?php

namespace App\Policies;

use App\Models\Highlight;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HighlightPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Highlight $highlight): bool
    {
        return $user->id === $highlight->user_id || $user->rule === 'manager';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Highlight $highlight): bool
    {
        return $user->id === $highlight->user_id || $user->rule === 'manager';
    }
}