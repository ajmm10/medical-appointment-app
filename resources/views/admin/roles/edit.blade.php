<x-admin-layout title="Editar" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
        'href' => route('admin.roles.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">
    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.roles.index') }}">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </x-wire-button>
    </x-slot>

    <x-wire-card>
        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            <x-wire-input
                label="Nombre"
                name="name"
                placeholder="Nombre del rol"
                value="{{ old('name', $role->name) }}"
            />

            <div class="mt-4 flex justify-end">
                <x-wire-button type="submit" blue>
                    Actualizar
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>
