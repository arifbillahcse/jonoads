<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, User $target): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    /** Editors can't change an admin account, which would otherwise let them demote or take it over. */
    public function update(User $user, User $target): bool
    {
        return $user->isAdmin() || ! $target->isAdmin();
    }

    /** Editors can't remove an admin account; nobody can delete their own. */
    public function delete(User $user, User $target): bool
    {
        if ($user->is($target)) {
            return false;
        }

        return $user->isAdmin() || ! $target->isAdmin();
    }
}
