<?php

namespace Exa\Http\Middlewares;

use Closure;
use Exa\Exceptions\AccessDeniedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Support\Roles;

final class HasRole
{
    /**
     * @throws AccessDeniedException
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();
        if (empty($user)) {
            throw new AccessDeniedException();
        }
        if ($user->is_admin) {
            return $next($request);
        }
        if ($user->hasRole(Roles::from($role))) {
            return $next($request);
        }
        throw new AccessDeniedException();
    }
}
