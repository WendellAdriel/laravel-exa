<?php

namespace Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'login-response',
    properties: [
        new OA\Property(property: 'type', type: 'string'),
        new OA\Property(property: 'token', type: 'string'),
    ],
)]
class LoginResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->resource['type'],
            'token' => $this->resource['token'],
        ];
    }
}
