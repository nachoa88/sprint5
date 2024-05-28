<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
 
    public function viewAny(User $authenticatedUser): Response
    {
        // Check if the user has the 'moderator' role.
        if (!$authenticatedUser->hasRole('moderator')) {
            return Response::deny('You do not have the required role to view users.');
        }

        // Check if the user has the 'view players' permission.
        if (!$authenticatedUser->hasPermissionTo('view players')) {
            return Response::deny('You do not have the required permission to view users.');
        }

        // If the check passes, allow the action.
        return Response::allow();
    }

    public function view(User $authenticatedUser, User $user): Response
    {
        // First, check if the authenticated user's UUID matches the user's UUID in the request.
        if ($authenticatedUser->uuid !== $user->uuid) {
            return Response::deny('Your UUID does not match the UUID in the request.');
        }

        // Check if the user has the 'player' role.
        if (!$authenticatedUser->hasRole('player')) {
            return Response::deny('You do not have the required role to view users.');
        }

        // Check if the user has the 'view own details' permission.
        if (!$authenticatedUser->hasPermissionTo('view own details')) {
            return Response::deny('You do not have the required permission to view users.');
        }
        // If all the checks pass, allow the action.
        return Response::allow();
    }

    public function update(User $authenticatedUser, User $user): Response
    {
        // First, check if the authenticated user's UUID matches the user's UUID in the request.
        if ($authenticatedUser->uuid !== $user->uuid) {
            return Response::deny('Your UUID does not match the UUID in the request.');
        }

        // Finally, check if the authenticated user has the 'player' role.
        if (!$authenticatedUser->hasRole('player')) {
            return Response::deny('You do not have the required role to edit players.');
        }

        // Next, check if the authenticated user has the 'edit nickname' permission.
        if (!$authenticatedUser->hasPermissionTo('edit nickname')) {
            return Response::deny('You do not have the required permission to edit your nickname.');
        }

        // If all checks pass, allow the action.
        return Response::allow();
    }

    public function deleteAllGames(User $authenticatedUser, User $user): Response
    {
        // First, check if the authenticated user's UUID matches the user's UUID in the request.
        if ($authenticatedUser->uuid !== $user->uuid) {
            return Response::deny('Your UUID does not match the UUID in the request.');
        }

        // Finally, check if the authenticated user has the 'player' role.
        if (!$authenticatedUser->hasRole('player')) {
            return Response::deny('You do not have the required role to delete the game history.');
        }

        // Next, check if the authenticated user has the 'delete own game history' permission.
        if (!$authenticatedUser->hasPermissionTo('delete own game history')) {
            return Response::deny('You do not have the required permission to delete the game history.');
        }

        // If all checks pass, allow the action.
        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
