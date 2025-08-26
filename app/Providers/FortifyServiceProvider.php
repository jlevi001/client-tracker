<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Tell Fortify which classes implement its contracts
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Rate limiters used by throttle:login and throttle:two-factor
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return [ Limit::perMinute(5)->by($email.$request->ip()) ];
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // (Optional) If you want to customize Fortify views later:
        // Fortify::loginView(fn () => view('auth.login'));
        // Fortify::registerView(fn () => view('auth.register'));
        // Fortify::requestPasswordResetLinkView(fn () => view('auth.forgot-password'));
        // Fortify::resetPasswordView(fn ($request) => view('auth.reset-password', ['request' => $request]));
        // Fortify::verifyEmailView(fn () => view('auth.verify-email'));
        // Fortify::twoFactorChallengeView(fn () => view('auth.two-factor-challenge'));
    }
}
