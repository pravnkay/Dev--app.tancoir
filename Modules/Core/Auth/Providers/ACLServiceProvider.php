<?php

namespace Modules\Core\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Modules\Core\Auth\Exceptions\CustomUnauthorizedException;

class ACLServiceProvider extends ServiceProvider
{

	public function boot(Router $router)
	{
		app()->make('router')->aliasMiddleware('role', \Spatie\Permission\Middleware\RoleMiddleware::class);
		app()->make('router')->aliasMiddleware('permission', \Spatie\Permission\Middleware\PermissionMiddleware::class);
		app()->make('router')->aliasMiddleware('role_or_permission', \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class);

		Gate::before(function ($user, $ability) {
            return $user->hasRole('root') ? true : null;
        });
	}
}