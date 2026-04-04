<?php

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;

it('seeds the default login user and additional test users with roles', function () {
    $this->seed(RoleSeeder::class);
    $this->seed(UserSeeder::class);

    $this->assertDatabaseHas('users', [
        'email' => 'test@test.com',
        'name' => 'Test User',
    ]);

    $loginUser = User::query()->where('email', 'test@test.com')->firstOrFail();

    expect($loginUser->hasRole('Administrador'))->toBeTrue();
    expect(User::query()->count())->toBe(13);
    expect(User::query()->withCount('roles')->get()->every(fn (User $user): bool => $user->roles_count > 0))->toBeTrue();
});

it('does not duplicate the seeded login user when run multiple times', function () {
    $this->seed(RoleSeeder::class);
    $this->seed(UserSeeder::class);
    $this->seed(UserSeeder::class);

    expect(User::query()->where('email', 'test@test.com')->count())->toBe(1);
});
