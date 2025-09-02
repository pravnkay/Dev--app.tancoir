<?php

namespace Modules\Core\Auth\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect('/backend');
        } else {
            return redirect('/app');
        }
    }
}