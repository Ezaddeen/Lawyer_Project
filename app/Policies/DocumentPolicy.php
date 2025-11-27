<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

     public function viewAny(User $user): bool
    {
        return $user->can('view_any_document') || $user->can('view_document');
    }

    public function view(User $user, Document $document): bool
    {
        if ($user->can('view_any_document')) {
            return true;
        }

        // المحامي يرى المستندات الخاصة به فقط
        if ($user->can('view_document') && $user->lawyer_id && $document->lawyer_id === $user->lawyer_id) {
            return true;
        }

        // العميل يرى المستندات الخاصة به فقط
        if ($user->can('view_document') && $user->client_id && $document->client_id === $user->client_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     return $user->can('view_any_document');
    // }

    /**
     * Determine whether the user can view the model.
     */
    // public function view(User $user, Document $document): bool
    // {
    //     return $user->can('view_document');
    // }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_document');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        return $user->can('update_document');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        return $user->can('delete_document');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_document');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Document $document): bool
    {
        return $user->can('force_delete_document');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_document');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Document $document): bool
    {
        return $user->can('restore_document');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_document');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Document $document): bool
    {
        return $user->can('replicate_document');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_document');
    }
}
