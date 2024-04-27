<?php

declare(strict_types=1);

use Modules\Auth\Models\User;
use Modules\Auth\Support\Role;

it('deletes user', function () {
    $newUser = testUser(Role::REGULAR);

    expect($this->actingAs(testUser(Role::ADMIN))->delete("v1/users/{$newUser->uuid}"))
        ->assertNoContent();

    $this->assertSoftDeleted(User::getModelTable(), [
        'email' => $newUser->email,
    ]);
});

it('fails to delete user for not manager user', function () {
    $newUser = testUser(Role::REGULAR);

    expect($this->actingAs(testUser(Role::REGULAR))->delete("v1/users/{$newUser->uuid}"))
        ->assertForbidden();
});

it('return 404 for user that does not exist', function () {
    expect($this->actingAs(testUser(Role::ADMIN))->delete('v1/users/test'))
        ->assertNotFound();
});
