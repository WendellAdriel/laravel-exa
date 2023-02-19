<?php

use Modules\Auth\Models\User;
use Modules\Auth\Support\Role;

it('creates a new user', function () {
    expect($this->actingAs(testUser(Role::ADMIN))->post('v1/users', dumbUserData()))
        ->assertCreated();

    $this->assertDatabaseHas(User::getModelTable(), [
        'email' => 'john.doe@example.com',
    ]);
});

it('fails to create user for not manager user', function () {
    expect($this->actingAs(testUser(Role::REGULAR))->post('v1/users', dumbUserData()))
        ->assertForbidden();
});
