<?php

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\User;
use Modules\Auth\Support\Role;

it('checks that admin user can update user email, role and active status', function () {
    $newUser = testUser(Role::REGULAR);
    $params = [
        'email' => 'test@test.com',
        'role' => Role::VIEWER->value,
        'active' => false,
    ];

    expect($this->actingAs(testUser(Role::ADMIN))->put("v1/users/{$newUser->uuid}", $params))
        ->assertOk();

    $this->assertDatabaseHas(User::getModelTable(), [
        'email' => 'test@test.com',
        'role' => Role::VIEWER->value,
        'active' => false,
    ]);
});

it('checks that non-admin user can not update user email, role and active status', function () {
    $newUser = testUser(Role::REGULAR);
    $params = [
        'email' => 'test@test.com',
        'role' => Role::VIEWER->value,
        'active' => false,
    ];

    expect($this->actingAs(testUser(Role::MANAGER))->put("v1/users/{$newUser->uuid}", $params))
        ->assertOk();

    $this->assertDatabaseMissing(User::getModelTable(), [
        'email' => 'test@test.com',
        'role' => Role::VIEWER->value,
        'active' => false,
    ]);
});

it('checks that user can update its own email', function () {
    $user = testUser(Role::MANAGER);
    $params = [
        'email' => 'test@test.com',
    ];

    expect($this->actingAs($user)->put("v1/users/{$user->uuid}", $params))
        ->assertOk();

    $this->assertDatabaseHas(User::getModelTable(), [
        'email' => 'test@test.com',
    ]);
});

it('checks that user can update its own password', function () {
    $user = testUser(Role::MANAGER);
    $params = [
        'current_password' => 'password',
        'password' => 's3CR3t@!',
        'password_confirmation' => 's3CR3t@!',
    ];

    expect($this->actingAs($user)->put("v1/users/{$user->uuid}", $params))
        ->assertOk();

    $this->assertDatabaseMissing(User::getModelTable(), [
        'email' => $user->email,
        'password' => Hash::make('password'),
    ]);
});

it('checks that user can not update its own password if current password is not correct', function () {
    $user = testUser(Role::MANAGER);
    $params = [
        'current_password' => 'test',
        'password' => 's3CR3t@!',
        'password_confirmation' => 's3CR3t@!',
    ];

    expect($this->actingAs($user)->put("v1/users/{$user->uuid}", $params))
        ->assertForbidden();

    $this->assertDatabaseMissing(User::getModelTable(), [
        'email' => $user->email,
        'password' => Hash::make('s3CR3t@!'),
    ]);
});

it('checks that user can not update password of other users', function () {
    $user = testUser(Role::REGULAR);
    $params = [
        'current_password' => 'password',
        'password' => 's3CR3t@!',
        'password_confirmation' => 's3CR3t@!',
    ];

    expect($this->actingAs(testUser(Role::ADMIN))->put("v1/users/{$user->uuid}", $params))
        ->assertOk();

    $this->assertDatabaseMissing(User::getModelTable(), [
        'email' => $user->email,
        'password' => Hash::make('s3CR3t@!'),
    ]);
});
