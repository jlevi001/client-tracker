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
        // $employeeUserId is optional context you can pass from Blade
        Gate::define('see-hourly-rate', function (User $user, $employeeUserId = null) {
            // Users with this permission (Accounting/Super Admin) can see all
            if ($user->can('view.hourly.rates')) {
                return true;
            }

            // Otherwise, allow only if they're viewing their own rate
            return $employeeUserId && (int)$employeeUserId === (int)$user->id;
        });
    }
}
