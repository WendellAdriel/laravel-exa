<?php

declare(strict_types=1);

use Modules\Auth\Models\User;
use Modules\Auth\Support\Role;

it('creates a new user', function (): void {
    $user = testUser(Role::ADMIN);
    expect($this->actingAs($user)->post('v1/users', dumbUserData()))
        ->assertCreated();

    $this->assertDatabaseHas(User::getModelTable(), [
        'email' => 'john.doe@example.com',
        'created_by' => $user->id,
    ]);
});

it('fails to create user for not manager user', function (): void {
    expect($this->actingAs(testUser(Role::REGULAR))->post('v1/users', dumbUserData()))
        ->assertForbidden();
});
