<?php

namespace Modules\Core\Auth\Providers;

use Modules\Core\Auth\Actions\Fortify\CreateNewUser;
use Modules\Core\Auth\Actions\Fortify\ResetUserPassword;
use Modules\Core\Auth\Actions\Fortify\UpdateUserPassword;
use Modules\Core\Auth\Actions\Fortify\UpdateUserProfileInformation;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Modules\Core\Auth\Responses\LoginResponse;
use RealRashid\SweetAlert\Facades\Alert;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);

		Fortify::loginView(function () {
			return view('auth::fortify.login');
		});

		Fortify::registerView(function () {
			return view('auth::fortify.register');
		});

		Fortify::verifyEmailView(function () {
			notify('Registered successfully!', ['icon' => 'circle-check-big']);
			return view('auth::fortify.verify-email');
		});

		Fortify::requestPasswordResetLinkView(function () {
			return view('auth::fortify.forgot-password');
		});

		Fortify::resetPasswordView(function (Request $request) {
			notify('Set your new password!', ['icon' => 'circle-check-big']);
			return view('auth::fortify.reset-password', ['request' => $request]);
		});

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

		$this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            LoginResponse::class
        );
    }
}
