<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public const DEFAULT_ROLES = [
        'Paciente',
        'Doctor',
        'Recepcionista',
        'Administrador',
        'Super administrador',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (self::DEFAULT_ROLES as $roleName) {
            Role::query()->updateOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ], [
                'is_system' => true,
            ]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
