<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function view(User $user)
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function edit(User $user)
    {
        return $user->isAdmin();
    }
}
