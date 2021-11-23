<?php

namespace App\Providers;

use App\Models\ConnectedAccount;
use App\Policies\ConnectedAccountPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Test;
use App\Models\User;
use App\Policies\CoursePolicy;
use App\Policies\GradePolicy;
use App\Policies\QuestionPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TestPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ConnectedAccount::class => ConnectedAccountPolicy::class,
        Course::class => CoursePolicy::class,
        Question::class => QuestionPolicy::class,
        Test::class => TestPolicy::class,
        User::class => UserPolicy::class,
        Grade::class => GradePolicy::class,
        Subject::class => SubjectPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('question-statistics', function(User $user) {
            return $user->role == User::ADMIN;
        });
    }
}
