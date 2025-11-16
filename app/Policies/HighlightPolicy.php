<?php

namespace App\Policies;

use App\Models\Highlight;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HighlightPolicy
{
    public function before(User $user,string $ability):bool|null
    {
        if($user->role==='admin'){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role=='writer';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Highlight $highlight): bool
    {
        return $user->id === $highlight -> author_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Highlight $highlight): bool
    {
        return $user->id === $highlight-> author_id;
    }
}
