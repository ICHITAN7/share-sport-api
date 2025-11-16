<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NewsPolicy
{
    /**
     * Allow admin to do anything.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null; // Let other methods decide
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Writers can also create
        return $user->role === 'writer';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, News $news): bool
    {
        // A writer can only update their own news
        return $user->id === $news->author_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, News $news): bool
    {
        // A writer can only delete their own news
        return $user->id === $news->author_id;
    }
}