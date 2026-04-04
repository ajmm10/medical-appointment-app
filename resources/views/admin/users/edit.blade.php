<x-admin-layout title="Editar usuario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],
    [
        'name' => 'Editar usuario',
    ],
]">
    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.users.index') }}">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </x-wire-button>
    </x-slot>

    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-center">
                <div class="space-y-2">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-600">
                        Actualizacion de usuarios
                    </p>
                    <h2 class="text-2xl font-semibold text-slate-900">
                        Modifica los datos del usuario sin perder su contexto actual
                    </h2>
                    <p class="max-w-2xl text-sm leading-6 text-slate-600">
                        Ajusta el nombre, el correo, el rol asignado y, si es necesario, reemplaza la contrasena del usuario desde un flujo de edicion controlado.
                    </p>
                </div>

                <div class="rounded-xl border border-amber-100 bg-amber-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-amber-600">Usuario seleccionado</p>
                    <p class="mt-2 text-sm font-medium text-amber-900">{{ $user->name }}</p>
                    <p class="mt-1 text-sm text-amber-800">{{ $user->email }}</p>
                </div>
            </div>
        </section>

        <x-wire-card>
            @include('admin.users.form', [
                'action' => route('admin.users.update', $user),
                'method' => 'PUT',
                'roles' => $roles,
                'selectedRoleId' => old('role_id', $user->roles->first()?->id),
                'submitLabel' => 'Actualizar usuario',
                'user' => $user,
            ])
        </x-wire-card>
    </div>
</x-admin-layout>
