<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use OpenApi\Attributes as OA;
use WendellAdriel\ValidatedDTO\Attributes\Rules;
use WendellAdriel\ValidatedDTO\Concerns\EmptyCasts;
use WendellAdriel\ValidatedDTO\Concerns\EmptyDefaults;
use WendellAdriel\ValidatedDTO\Concerns\EmptyRules;
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
    use EmptyCasts,
        EmptyDefaults,
        EmptyRules;

    #[Rules(['required', 'email'])]
    public string $email;

    #[Rules(['required', 'string'])]
    public string $password;
}
