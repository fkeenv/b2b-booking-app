<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Guest;
use App\Models\User;

class GuestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Guest');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Guest $guest): bool
    {
        return $user->checkPermissionTo('view Guest');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Guest');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Guest $guest): bool
    {
        return $user->checkPermissionTo('update Guest');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Guest $guest): bool
    {
        return $user->checkPermissionTo('delete Guest');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Guest');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Guest $guest): bool
    {
        return $user->checkPermissionTo('restore Guest');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Guest');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Guest $guest): bool
    {
        return $user->checkPermissionTo('replicate Guest');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Guest');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Guest $guest): bool
    {
        return $user->checkPermissionTo('force-delete Guest');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Guest');
    }
}
