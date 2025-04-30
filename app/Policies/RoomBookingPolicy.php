<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\RoomBooking;
use App\Models\User;

class RoomBookingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any RoomBooking');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RoomBooking $roombooking): bool
    {
        return $user->checkPermissionTo('view RoomBooking');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create RoomBooking');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RoomBooking $roombooking): bool
    {
        return $user->checkPermissionTo('update RoomBooking');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RoomBooking $roombooking): bool
    {
        return $user->checkPermissionTo('delete RoomBooking');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any RoomBooking');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RoomBooking $roombooking): bool
    {
        return $user->checkPermissionTo('restore RoomBooking');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any RoomBooking');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, RoomBooking $roombooking): bool
    {
        return $user->checkPermissionTo('replicate RoomBooking');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder RoomBooking');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RoomBooking $roombooking): bool
    {
        return $user->checkPermissionTo('force-delete RoomBooking');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any RoomBooking');
    }
}
