<?php

use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

it('adds the system protection column to roles', function () {
    expect(Schema::hasColumn('roles', 'is_system'))->toBeTrue();
});

it('seeds default roles as system roles', function () {
    $this->seed(RoleSeeder::class);

    foreach (RoleSeeder::DEFAULT_ROLES as $roleName) {
        $this->assertDatabaseHas('roles', [
            'name' => $roleName,
            'guard_name' => 'web',
            'is_system' => true,
        ]);
    }

    expect(Role::query()->count())->toBe(count(RoleSeeder::DEFAULT_ROLES));
});

it('does not duplicate roles when seeded multiple times', function () {
    $this->seed(RoleSeeder::class);
    $this->seed(RoleSeeder::class);

    foreach (RoleSeeder::DEFAULT_ROLES as $roleName) {
        $this->assertDatabaseHas('roles', [
            'name' => $roleName,
            'guard_name' => 'web',
            'is_system' => true,
        ]);
    }

    expect(Role::query()->count())->toBe(count(RoleSeeder::DEFAULT_ROLES));
});
