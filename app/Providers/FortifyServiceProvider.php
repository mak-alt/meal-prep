<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Responses\LoginResponse as CustomLoginResponse;
use App\Http\Responses\LogoutResponse as CustomLogoutResponse;
use App\Http\Responses\RegisterResponse as CustomRegisterResponse;
use App\Http\Responses\ResetPasswordResponse;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\PasswordResetResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Auth logic
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::authenticateUsing(function (Request $request) {
            return $this->authenticateUser($request);
        });
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::resetPasswordView('frontend.password-reset');

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->name . $request->ip());
        });
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Register custom views
        Fortify::loginView('frontend.landing.index');
        Fortify::registerView('frontend.landing.index');

        // Register custom responses
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);
        $this->app->singleton(RegisterResponse::class, CustomRegisterResponse::class);
        $this->app->singleton(PasswordResetResponse::class, ResetPasswordResponse::class);
        $this->app->singleton(LogoutResponse::class, CustomLogoutResponse::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    private function authenticateUser(Request $request)
    {
        $user = User::where('name', $request->name)
            ->orWhere('email', $request->name)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $requestPath       = str_replace(url('/'), '', url()->previous());
            $authRoleCondition = $requestPath === '/admin/login' ? $user->isAdmin() : $user->isCustomer();

            if (!$authRoleCondition) {
                throw ValidationException::withMessages([Fortify::username() => __('auth.failed')]);
            }
            if ($user->isInactive()) {
                throw ValidationException::withMessages([
                    Fortify::username() => 'Your account is in an inactive status, wait until it is confirmed by the administrator.',
                ]);
            }
            if ($user->isBanned()) {
                throw ValidationException::withMessages([Fortify::username() => 'Your account is banned.']);
            }

            return $user;
        }

        throw ValidationException::withMessages([Fortify::username() => __('auth.failed')]);
    }
}
