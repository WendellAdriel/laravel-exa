<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Modules\Auth\Support\Role;
use OpenApi\Attributes as OA;
use WendellAdriel\ValidatedDTO\Attributes\Cast;
use WendellAdriel\ValidatedDTO\Attributes\DefaultValue;
use WendellAdriel\ValidatedDTO\Casting\EnumCast;
use WendellAdriel\ValidatedDTO\Concerns\EmptyCasts;
use WendellAdriel\ValidatedDTO\Concerns\EmptyDefaults;
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
final class CreateUserDTO extends ValidatedDTO
{
    use EmptyCasts,
        EmptyDefaults;

    public string $name;

    public string $email;

    public string $password;

    #[Cast(type: EnumCast::class, param: Role::class)]
    #[DefaultValue(Role::REGULAR)]
    public Role $role;

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
}
