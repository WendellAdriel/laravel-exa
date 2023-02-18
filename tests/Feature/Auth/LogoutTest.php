<?php

it('logout successfully', function () {
    $this->actingAs(testAdminUser());

    expect($this->post('v1/auth/logout'))
        ->assertNoContent();
});
