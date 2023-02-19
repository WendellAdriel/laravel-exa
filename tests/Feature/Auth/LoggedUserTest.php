<?php

use Modules\Auth\Support\Role;

it('gets the logged user', function () {
    $user = testUser(Role::ADMIN);
    $this->actingAs($user);

    expect($this->get('v1/auth/me')->json())
        ->toBe([
            'uuid' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'active' => $user->active,
            'created_at' => $user->created_at->toISOString(),
            'updated_at' => $user->updated_at->toISOString(),
        ]);
});
