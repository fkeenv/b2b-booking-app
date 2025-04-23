<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Accommodation;
use App\Models\User;

class AccommodationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Accommodation');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Accommodation $accommodation): bool
    {
        return $user->checkPermissionTo('view Accommodation');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Accommodation');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Accommodation $accommodation): bool
    {
        return $user->checkPermissionTo('update Accommodation');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Accommodation $accommodation): bool
    {
        return $user->checkPermissionTo('delete Accommodation');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Accommodation');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Accommodation $accommodation): bool
    {
        return $user->checkPermissionTo('restore Accommodation');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Accommodation');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Accommodation $accommodation): bool
    {
        return $user->checkPermissionTo('replicate Accommodation');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Accommodation');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Accommodation $accommodation): bool
    {
        return $user->checkPermissionTo('force-delete Accommodation');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Accommodation');
    }
}
