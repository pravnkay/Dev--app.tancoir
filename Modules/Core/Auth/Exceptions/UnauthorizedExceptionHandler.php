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

		notify('No access! Re-routed', ['status'=> 'destructive', 'icon' => 'ban']);

        if ($user && $user->hasRole('admin')) {
            return redirect()
                ->route('backend.dashboard');
        }

        if ($user) {
            return redirect()
                ->route('app.registry.index');
        }

        return redirect()->route('core.index');
    }
}
