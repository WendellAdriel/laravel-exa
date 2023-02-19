<?php

namespace Modules\Auth\DTOs;

use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Modules\Auth\Support\Role;
use WendellAdriel\ValidatedDTO\Casting\BooleanCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

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
