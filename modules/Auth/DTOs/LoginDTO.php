<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use OpenApi\Attributes as OA;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

#[OA\Schema(
    schema: 'login',
    required: ['email', 'password'],
    properties: [
        new OA\Property(property: 'email', type: 'string'),
        new OA\Property(property: 'password', type: 'string'),
    ],
)]
final class LoginDTO extends ValidatedDTO
{
    public string $email;

    public string $password;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
