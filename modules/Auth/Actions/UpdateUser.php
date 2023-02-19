<?php

namespace Modules\Auth\Actions;

use Exa\Exceptions\AccessDeniedException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\DTOs\UpdateUserDTO;
use Modules\Auth\Models\User;

final readonly class UpdateUser
{
    public function __construct(private FetchUser $fetchUser)
    {
    }

    public function handle(string $uuid, UpdateUserDTO $dto): User
    {
        $authUser = Auth::user();
        $user = $this->fetchUser->handle($uuid);
        $updateData = collect($dto->toArray())->filter(fn ($item) => ! is_null($item))->toArray();

        if (! $authUser->is_admin) {
            unset($updateData['role'], $updateData['active']);
        }

        if ($authUser->uuid !== $uuid && ! $authUser->is_admin) {
            unset($updateData['email']);
        }

        if ($authUser->uuid !== $uuid) {
            unset($updateData['password']);
        }

        $updateData = $this->buildPasswordData($user, $updateData);
        $user->fill($updateData);
        $user->save();

        return $user;
    }

    private function buildPasswordData(User $user, array $updateData): array
    {
        if (! empty($updateData['password'])) {
            if (! Hash::check($updateData['current_password'], $user->password)) {
                throw new AccessDeniedException();
            }
            $updateData['password'] = Hash::make($updateData['password']);
        }

        unset($updateData['current_password']);

        return $updateData;
    }
}
