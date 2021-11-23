<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function create(User $user)
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function edit(User $user, Course $course)
    {
        return $user->id === $course->editor_id;
    }

    public function delete(User $user, Course $course)
    {
        return $user->id === $course->editor_id;
    }
}
