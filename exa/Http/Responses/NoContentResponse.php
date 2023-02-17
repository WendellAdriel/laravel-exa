<?php

namespace Exa\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

readonly class NoContentResponse implements Responsable
{
    public function __construct(
        private int $code = Response::HTTP_NO_CONTENT,
        private array $headers = []
    ) {
    }

    public function toResponse($request): Response
    {
        return response()->noContent($this->code, $this->headers);
    }
}
