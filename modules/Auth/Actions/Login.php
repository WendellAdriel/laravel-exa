<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\DTOs\LoginDTO;
use Modules\Auth\Models\User;
use Modules\Auth\Models\UserLogin;

final readonly class Login
{
    private const string TOKEN_TYPE = 'Bearer';

    public function handle(LoginDTO $dto): array
    {
        $token = Auth::attempt($dto->toArray());
        if (! $token) {
            throw new AuthenticationException();
        }

        /** @var User $user */
        $user = Auth::user();
        $this->recordLogin($user);

        return [
            'type' => self::TOKEN_TYPE,
            'token' => $token,
        ];
    }

    private function recordLogin(User $user): void
    {
        UserLogin::query()->create([
            'user_id' => $user->id,
            'ip' => request()->ip(),
            'user_agent' => request()->header('user-agent'),
        ]);
    }
}
