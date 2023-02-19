<?php

use Modules\Auth\Support\Role;

it('gets user info', function () {
    $newUser = testUser(Role::REGULAR);

    expect($this->actingAs(testUser(Role::ADMIN))->get("v1/users/{$newUser->uuid}")->json())
        ->toBe([
            'uuid' => $newUser->uuid,
            'name' => $newUser->name,
            'email' => $newUser->email,
            'role' => $newUser->role,
            'active' => $newUser->active,
            'created_at' => $newUser->created_at->toISOString(),
            'updated_at' => $newUser->updated_at->toISOString(),
        ]);
});

it('return 404 for user that does not exist', function () {
    expect($this->actingAs(testUser(Role::ADMIN))->get('v1/users/test'))
        ->assertNotFound();
});
