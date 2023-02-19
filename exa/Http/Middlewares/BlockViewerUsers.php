<?php

namespace Exa\Http\Middlewares;

use Closure;
use Exa\Exceptions\AccessDeniedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class BlockViewerUsers
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (is_null($user)) {
            return $next($request);
        }
        if ($request->path() === 'v1/auth/logout') {
            return $next($request);
        }
        if ($user->is_viewer && ! $request->isMethod('get')) {
            throw new AccessDeniedException();
        }

        return $next($request);
    }
}
