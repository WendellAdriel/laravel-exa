<?php

declare(strict_types=1);

use Modules\Auth\Support\Role;

it('logins successfully', function (): void {
    $user = testUser(Role::ADMIN);
    $params = [
        'email' => $user->email,
        'password' => 'password',
    ];

    expect($this->post('v1/auth/login', $params)->json())
        ->toHaveKeys(['type', 'token']);
});

it('fails to login with wrong credentials', function (): void {
    $user = testUser(Role::ADMIN);
    $params = [
        'email' => $user->email,
        'password' => 'test',
    ];

    expect($this->post('v1/auth/login', $params))
        ->assertUnauthorized();
});
