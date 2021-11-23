<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function edit(User $user, User $object)
    {
        return $user->isAdmin() && ($user->id == $object->id || !$object->isAdmin());
    }

    public function delete(User $user, User $object)
    {
        return !$object->isAdmin() &&
            $user->isAdmin() &&
            $user->id != $object->id;
    }
}
