<?php

use Modules\Auth\Actions\HasRole;
use Modules\Auth\Support\Role;

beforeEach(function () {
    $this->action = resolve(HasRole::class);
});

it('returns true for correct role', function () {
    $user = testUser(Role::VIEWER);

    expect($this->action->handle($user, Role::VIEWER))
        ->toBeTrue();
});

it('returns false for wrong role', function () {
    $user = testUser(Role::VIEWER);

    expect($this->action->handle($user, Role::REGULAR))
        ->toBeFalse();
});

it('checks that admin role overrides other roles', function () {
    $user = testUser(Role::ADMIN);

    expect($this->action->handle($user, Role::MANAGER))
        ->toBeTrue();
});
