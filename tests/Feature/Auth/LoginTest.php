<?php

use Modules\Auth\Support\Role;

it('logins successfully', function () {
    $user = testUser(Role::ADMIN);
    $params = [
        'email' => $user->email,
        'password' => 'password',
    ];

    expect($this->post('v1/auth/login', $params)->json())
        ->toHaveKeys(['type', 'token']);
});

it('fails to login with wrong credentials', function () {
    $user = testUser(Role::ADMIN);
    $params = [
        'email' => $user->email,
        'password' => 'test',
    ];

    expect($this->post('v1/auth/login', $params))
        ->assertUnauthorized();
});
