<?php

namespace Modules\Auth\Actions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Auth\DTOs\LoginDTO;
use Modules\Auth\Models\User;
use Modules\Auth\Models\UserLogin;

final readonly class Login
{
    private const TOKEN_TYPE = 'Bearer';

    public function handle(LoginDTO $dto): array
    {
        if (! Auth::attempt($dto->toArray())) {
            throw new AuthenticationException();
        }

        /** @var User $user */
        $user = Auth::user();
        $this->recordLogin($user);

        return [
            'type' => self::TOKEN_TYPE,
            'token' => $user->createToken(Str::slug(config('app.name').'_login'))->plainTextToken,
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
