<?php

use Database\Seeders\RoleSeeder;
use Spatie\Permission\Models\Role;

it('seeds default roles', function () {
    $this->seed(RoleSeeder::class);

    foreach (RoleSeeder::DEFAULT_ROLES as $roleName) {
        $this->assertDatabaseHas('roles', [
            'name' => $roleName,
            'guard_name' => 'web',
        ]);
    }

    expect(Role::query()->count())->toBe(count(RoleSeeder::DEFAULT_ROLES));
});

it('does not duplicate roles when seeded multiple times', function () {
    $this->seed(RoleSeeder::class);
    $this->seed(RoleSeeder::class);

    expect(Role::query()->count())->toBe(count(RoleSeeder::DEFAULT_ROLES));
});
