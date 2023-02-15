<?php

namespace Exa\Exceptions;

use Illuminate\Http\Response;

class AccessDeniedException extends ExaException
{
    public function __construct()
    {
        parent::__construct('Access Denied', Response::HTTP_FORBIDDEN);
    }
}
