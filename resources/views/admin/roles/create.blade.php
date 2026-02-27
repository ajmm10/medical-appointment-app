<x-admin-layout title="Crear rol" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
        'href' => route('admin.roles.index'),
    ],
    [
        'name' => 'Crear rol',
    ],
]">
    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.roles.index') }}">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </x-wire-button>
    </x-slot>

    <x-wire-card>

        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <x-wire-input 
                label="Nombre"
                name="name"
                placeholder="Nombre del rol"
                value="{{ old('name') }}"
            />

            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" blue>
                    Guardar
                </x-wire-button>
            </div>

        </form>

    </x-wire-card>

</x-admin-layout>
