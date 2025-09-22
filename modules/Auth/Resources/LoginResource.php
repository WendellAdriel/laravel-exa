<?php

declare(strict_types=1);

namespace Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
use Override;

#[OA\Schema(
    schema: 'login-response',
    properties: [
        new OA\Property(property: 'type', type: 'string'),
        new OA\Property(property: 'token', type: 'string'),
    ],
)]
final class LoginResource extends JsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->resource['type'],
            'token' => $this->resource['token'],
        ];
    }
}
