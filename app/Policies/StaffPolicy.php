<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Staff;
use App\Models\User;

class StaffPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Staff');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Staff $staff): bool
    {
        return $user->checkPermissionTo('view Staff');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Staff');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Staff $staff): bool
    {
        return $user->checkPermissionTo('update Staff');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Staff $staff): bool
    {
        return $user->checkPermissionTo('delete Staff');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Staff');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Staff $staff): bool
    {
        return $user->checkPermissionTo('restore Staff');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Staff');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Staff $staff): bool
    {
        return $user->checkPermissionTo('replicate Staff');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Staff');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Staff $staff): bool
    {
        return $user->checkPermissionTo('force-delete Staff');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Staff');
    }
}
