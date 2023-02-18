<?php

use Modules\Auth\Support\Roles;

it('logout successfully', function () {
    $this->actingAs(testUser(Roles::ADMIN));

    expect($this->post('v1/auth/logout'))
        ->assertNoContent();
});
