<?php

use Modules\Auth\Support\Role;

it('gets the list of users', function () {
    foreach (range(1, 9) as $number) {
        testUser(Role::REGULAR);
    }

    $content = $this->actingAs(testUser(Role::ADMIN))->get('v1/users')->json();

    expect($content)
        ->toHaveKeys(['data', 'links', 'meta'])
        ->and($content['data'])
        ->toBeArray()
        ->toHaveCount(10)
        ->and($content['meta']['current_page'])
        ->toBe(1)
        ->and($content['meta']['last_page'])
        ->toBe(1)
        ->and($content['meta']['per_page'])
        ->toBe(20)
        ->and($content['meta']['total'])
        ->toBe(10);
});
