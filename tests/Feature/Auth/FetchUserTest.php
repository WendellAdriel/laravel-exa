<?php

declare(strict_types=1);

use Modules\Auth\Support\Role;

it('gets user info', function (): void {
    $newUser = testUser(Role::REGULAR);

    expect($this->actingAs(testUser(Role::ADMIN))->get("v1/users/{$newUser->uuid}")->json())
        ->toBe([
            'uuid' => $newUser->uuid,
            'name' => $newUser->name,
            'email' => $newUser->email,
            'role' => $newUser->role->value,
            'active' => $newUser->active,
            'created_at' => $newUser->created_at->toISOString(),
            'updated_at' => $newUser->updated_at->toISOString(),
        ]);
});

it('return 404 for user that does not exist', function (): void {
    expect($this->actingAs(testUser(Role::ADMIN))->get('v1/users/test'))
        ->assertNotFound();
});
