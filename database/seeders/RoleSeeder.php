<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
        foreach (self::DEFAULT_ROLES as $roleName) {
            Role::findOrCreate($roleName, 'web');
        }
    }
}
