<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Modules\Core\Auth\Exceptions\UnauthorizedExceptionHandler;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
		//
    )
    ->withMiddleware(function (Middleware $middleware): void {
		$middleware->redirectGuestsTo('/');
    })
    ->withExceptions(function (Exceptions $exceptions): void {

		$exceptions->renderable(new UnauthorizedExceptionHandler);

    })->create();
