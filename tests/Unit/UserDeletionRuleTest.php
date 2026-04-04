<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('a user cannot delete themself', function () {
    $user = User::factory()->create();

    expect($user->deletionProtectionMessage($user))
        ->toBe('No puedes eliminar tu propia cuenta.');
});

test('the principal administrator cannot be deleted by another user', function () {
    $admin = User::factory()->create();
    $principalAdmin = User::factory()->create([
        'email' => 'test@test.com',
    ]);

    $principalAdmin->assignRole(Role::findOrCreate('Super administrador', 'web'));

    expect($principalAdmin->deletionProtectionMessage($admin))
        ->toBe('No puedes eliminar al administrador principal.');
});
