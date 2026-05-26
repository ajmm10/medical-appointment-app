<x-admin-layout title="Editar" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">
    <x-wire-card>
        @include('admin.users.form', [
            'action' => route('admin.users.update', $user),
            'method' => 'PUT',
            'roles' => $roles,
            'selectedRoleId' => old('role_id', $user->roles->first()?->id),
            'submitLabel' => 'Actualizar',
            'user' => $user,
        ])
    </x-wire-card>
</x-admin-layout>
