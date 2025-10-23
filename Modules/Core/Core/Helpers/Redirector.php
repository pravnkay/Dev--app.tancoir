<?php

function resolve_role_redirect(?Illuminate\Contracts\Auth\Authenticatable $user): ?string {

    if (! $user) {
        return config('redirects.fallback');
    }

    foreach ($user->getRoleNames() as $role) {
        if ($route = config("redirects.routes.$role")) {
            return $route;
        }
    }

    return config('redirects.fallback');
	
}
