<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Lecturers + admins can manage documents (CRUD)
        Gate::define('manage-documents', fn(User $user) => $user->isAdmin() || $user->isLecturer());


        // Students + lecturers + admins can download documents
        Gate::define('download-documents', function (User $user) {
            return in_array($user->role, ['student', 'lecturer', 'admin'], true);
        });

        // Students + lecturers + admins can comment
        Gate::define('comment-documents', function (User $user) {
            return in_array($user->role, ['student', 'lecturer', 'admin'], true);
        });

        // Only admins can manage users
        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin();
        });
    }
}
