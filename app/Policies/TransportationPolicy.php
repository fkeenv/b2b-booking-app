<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Transportation;
use App\Models\User;

class TransportationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Transportation');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Transportation $transportation): bool
    {
        return $user->checkPermissionTo('view Transportation');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Transportation');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Transportation $transportation): bool
    {
        return $user->checkPermissionTo('update Transportation');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Transportation $transportation): bool
    {
        return $user->checkPermissionTo('delete Transportation');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Transportation');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Transportation $transportation): bool
    {
        return $user->checkPermissionTo('restore Transportation');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Transportation');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Transportation $transportation): bool
    {
        return $user->checkPermissionTo('replicate Transportation');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Transportation');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Transportation $transportation): bool
    {
        return $user->checkPermissionTo('force-delete Transportation');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Transportation');
    }
}
