<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hearing;
use Illuminate\Auth\Access\HandlesAuthorization;

class HearingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
{
    return $user->can('view_any_hearing') || $user->can('view_hearing');
}

public function view(User $user, Hearing $hearing): bool
{
    if ($user->can('view_any_hearing')) {
        return true;
    }

    // المحامي يرى الجلسات الخاصة به فقط
    if ($user->can('view_hearing') && $user->lawyer_id && $hearing->lawyer_id === $user->lawyer_id) {
        return true;
    }

    // العميل يرى الجلسات الخاصة به فقط
    if ($user->can('view_hearing') && $user->client_id && $hearing->client_id === $user->client_id) {
        return true;
    }

    return false;
}

    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     return $user->can('view_any_hearing');
    // }

    /**
     * Determine whether the user can view the model.
     */
    // public function view(User $user, Hearing $hearing): bool
    // {
    //     return $user->can('view_hearing');
    // }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_hearing');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Hearing $hearing): bool
    {
        return $user->can('update_hearing');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hearing $hearing): bool
    {
        return $user->can('delete_hearing');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_hearing');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Hearing $hearing): bool
    {
        return $user->can('force_delete_hearing');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_hearing');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Hearing $hearing): bool
    {
        return $user->can('restore_hearing');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_hearing');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Hearing $hearing): bool
    {
        return $user->can('replicate_hearing');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_hearing');
    }
}
