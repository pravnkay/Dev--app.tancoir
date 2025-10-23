<?php

namespace Modules\Core\Auth\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UnauthorizedExceptionHandler
{
    /**
     * Handle the given exception.
     * This method is called when the class is "invoked" like a function.
     */
    public function __invoke(UnauthorizedException $e, Request $request)
    {
        $user = Auth::user();

        notify('No access! Re-routed', ['status' => 'destructive', 'icon' => 'ban']);

        $routeName = resolve_role_redirect($user);        // falls back to core.index if user null/unknown
        return redirect()->route($routeName);
    }
}
