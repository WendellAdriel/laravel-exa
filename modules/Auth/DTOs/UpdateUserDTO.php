<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Modules\Auth\Support\Role;
use OpenApi\Attributes as OA;
use WendellAdriel\ValidatedDTO\Attributes\Cast;
use WendellAdriel\ValidatedDTO\Casting\BooleanCast;
use WendellAdriel\ValidatedDTO\Concerns\EmptyCasts;
use WendellAdriel\ValidatedDTO\Concerns\EmptyDefaults;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

#[OA\Schema(
    schema: 'update-user',
    properties: [
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'email', type: 'string'),
        new OA\Property(property: 'current_password', type: 'string'),
        new OA\Property(property: 'password', type: 'string'),
        new OA\Property(property: 'password_confirmation', type: 'string'),
        new OA\Property(property: 'role', type: 'string', default: 'regular', enum: ['viewer', 'regular', 'manager', 'admin']),
        new OA\Property(property: 'active', type: 'boolean'),
    ],
)]
final class UpdateUserDTO extends ValidatedDTO
{
    use EmptyCasts;
    use EmptyDefaults;

    public ?string $name = null;

    public ?string $email = null;

    public ?string $current_password = null;

    public ?string $password = null;

    public ?string $role = null;

    #[Cast(BooleanCast::class)]
    public bool $active;

    protected function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'min:4'],
            'email' => ['sometimes', 'email'],
            'current_password' => ['required_with:password', 'string'],
            'password' => [
                'sometimes',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ],
            'role' => ['sometimes', 'string', new Enum(Role::class)],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
