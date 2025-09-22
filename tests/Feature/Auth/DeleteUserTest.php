<?php

declare(strict_types=1);

use Modules\Auth\Models\User;
use Modules\Auth\Support\Role;

it('deletes user', function (): void {
    $newUser = testUser(Role::REGULAR);
    $adminUser = testUser(Role::ADMIN);

    expect($this->actingAs($adminUser)->delete("v1/users/{$newUser->uuid}"))
        ->assertNoContent();

    $this->assertSoftDeleted(User::getModelTable(), [
        'email' => $newUser->email,
        'deleted_by' => $adminUser->id,
    ]);
});

it('fails to delete user for not manager user', function (): void {
    $newUser = testUser(Role::REGULAR);

    expect($this->actingAs(testUser(Role::REGULAR))->delete("v1/users/{$newUser->uuid}"))
        ->assertForbidden();
});

it('return 404 for user that does not exist', function (): void {
    expect($this->actingAs(testUser(Role::ADMIN))->delete('v1/users/test'))
        ->assertNotFound();
});
