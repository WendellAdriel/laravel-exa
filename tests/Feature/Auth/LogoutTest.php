<?php

use Modules\Auth\Support\Role;

it('logout successfully', function () {
    $this->actingAs(testUser(Role::ADMIN));

    expect($this->post('v1/auth/logout'))
        ->assertNoContent();
});
