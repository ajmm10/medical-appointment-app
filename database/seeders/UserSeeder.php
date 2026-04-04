<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::query()->pluck('name');

        $adminUser = User::query()->firstOrCreate([
            'email' => 'test@test.com',
        ], [
            'name' => 'Test User',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        $adminUser->syncRoles(['Administrador']);

        User::factory()
            ->count(12)
            ->create()
            ->each(function (User $user) use ($roles): void {
                $user->syncRoles([$roles->random()]);
            });
    }
}
