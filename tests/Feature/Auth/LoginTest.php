<?php

use Illuminate\Auth\AuthenticationException;
use Modules\Auth\Actions\Login;
use Modules\Auth\DTOs\LoginDTO;

it('logins successfully', function () {
    $user = testAdminUser();

    $action = resolve(Login::class);
    $dto = new LoginDTO([
        'email' => $user->email,
        'password' => 'password',
    ]);

    expect($action->handle($dto))
        ->toBeArray()
        ->toHaveKeys(['type', 'token']);
});

it('fails to login with wrong credentials', function () {
    $user = testAdminUser();

    $action = resolve(Login::class);
    $dto = new LoginDTO([
        'email' => $user->email,
        'password' => 'test',
    ]);

    $this->expectException(AuthenticationException::class);
    $action->handle($dto);
});
