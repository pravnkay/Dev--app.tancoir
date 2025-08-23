<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException; // <-- Import Spatie's exception
use Illuminate\Support\Facades\Auth;
use Throwable;

class Handler extends ExceptionHandler
{
    // ... (other properties like $dontFlash)

    public function register()
    {
        $this->reportable(function (Throwable $e) {
			// This will catch EVERYTHING.
			dd($e);
		});
    }
}
