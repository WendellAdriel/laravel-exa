<?php

namespace Exa\Http\Middlewares;

use Closure;
use Exa\Exceptions\AccessDeniedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Actions\HasRole as HasRoleAction;
use Modules\Auth\Support\Role;

final readonly class HasRole
{
    public function __construct(private HasRoleAction $action)
    {
    }

    /**
     * @throws AccessDeniedException
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();
        if (is_null($user)) {
            throw new AccessDeniedException();
        }
        if (! $this->action->handle($user, Role::from($role))) {
            throw new AccessDeniedException();
        }

        return $next($request);
    }
}
