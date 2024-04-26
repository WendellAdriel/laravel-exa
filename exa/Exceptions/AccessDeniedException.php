<?php

declare(strict_types=1);

namespace Exa\Exceptions;

use Illuminate\Http\Response;

final class AccessDeniedException extends ExaException
{
    public function __construct()
    {
        parent::__construct('Access Denied', Response::HTTP_FORBIDDEN);
    }
}
