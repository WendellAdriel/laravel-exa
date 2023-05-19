<?php

declare(strict_types=1);

use Modules\Auth\Support\Role;

it('logout successfully', function () {
    $this->actingAs(testUser(Role::ADMIN));

    expect($this->post('v1/auth/logout'))
        ->assertNoContent();
});
