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
        $target_route = resolve_role_redirect($user);           // returns name from config/redirects.php
		clock($target_route);
        return redirect()->route($target_route);
    }
}