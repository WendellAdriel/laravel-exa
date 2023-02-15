<?php

namespace Exa\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

readonly class ApiSuccessResponse implements Responsable
{
    public function __construct(
        private mixed $data,
        private array $metadata = [],
        private int $code = Response::HTTP_OK,
        private array $headers = []
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json(
            [
                'data' => $this->data,
                'metadata' => $this->metadata,
            ],
            $this->code,
            $this->headers
        );
    }
}
