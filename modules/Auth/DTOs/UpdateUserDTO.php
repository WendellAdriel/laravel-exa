<?php

namespace Modules\Auth\DTOs;

use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use OpenApi\Attributes as OA;
use Modules\Auth\Support\Role;
use WendellAdriel\ValidatedDTO\Casting\BooleanCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

#[OA\Schema(
    schema: 'update-user',
    properties: [
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'email', type: 'string'),
        new OA\Property(property: 'current_password', type: 'string'),
        new OA\Property(property: 'password', type: 'string'),
        new OA\Property(property: 'role', type: 'string', default: 'regular', enum: ['viewer', 'regular', 'manager', 'admin']),
        new OA\Property(property: 'active', type: 'boolean'),
    ],
)]
class UpdateUserDTO extends ValidatedDTO
{
    public ?string $name;

    public ?string $email;

    public ?string $current_password;

    public ?string $password;

    public ?string $role;

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

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'active' => new BooleanCast(),
        ];
    }
}
