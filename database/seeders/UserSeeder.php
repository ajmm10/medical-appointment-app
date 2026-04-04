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
        $assignableRoles = Role::query()
            ->where('name', '!=', 'Super administrador')
            ->pluck('name');

        $adminUser = User::query()->firstOrCreate([
            'email' => 'test@test.com',
        ], [
            'name' => 'Test User',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        $adminUser->syncRoles(['Administrador', 'Super administrador']);

        User::factory()
            ->count(12)
            ->create()
            ->each(function (User $user) use ($assignableRoles): void {
                $user->syncRoles([$assignableRoles->random()]);
            });
    }
}
