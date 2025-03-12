<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

final readonly class DeleteUser
{
    public function __construct(private FetchUser $fetchUser) {}

    public function handle(string $uuid): void
    {
        $user = $this->fetchUser->handle($uuid);
        $user->delete();
    }
}
