<?php

namespace App\Policies;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BannerPolicy
{
    public function view(User $user, Banner $banner): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     * Only admins can create.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     * Only admins can update.
     */
    public function update(User $user, Banner $banner): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     * Only admins can delete.
     */
    public function delete(User $user, Banner $banner): bool
    {
        return $user->role === 'admin';
    }
}
