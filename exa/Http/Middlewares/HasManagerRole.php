<?php

namespace Exa\Http\Middlewares;

use Closure;
use Exa\Exceptions\AccessDeniedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasManagerRole
{
    /**
     * @throws AccessDeniedException
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (empty($user)) {
            throw new AccessDeniedException();
        }
        if ($user->is_admin || $user->is_manager) {
            return $next($request);
        }
        throw new AccessDeniedException();
    }
}
