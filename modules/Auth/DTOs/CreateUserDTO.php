<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Modules\Auth\Support\Role;
use OpenApi\Attributes as OA;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

#[OA\Schema(
    schema: 'create-user',
    required: ['name', 'email', 'password'],
    properties: [
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'email', type: 'string'),
        new OA\Property(property: 'password', type: 'string'),
        new OA\Property(property: 'password_confirmation', type: 'string'),
        new OA\Property(property: 'role', type: 'string', default: 'regular', enum: ['viewer', 'regular', 'manager', 'admin']),
    ],
)]
class CreateUserDTO extends ValidatedDTO
{
    public string $name;

    public string $email;

    public string $password;

    public string $role;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ],
            'role' => ['sometimes', 'string', new Enum(Role::class)],
        ];
    }

    protected function defaults(): array
    {
        return [
            'role' => Role::REGULAR->value,
        ];
    }

    protected function casts(): array
    {
        return [];
    }
}
