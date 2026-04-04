<x-admin-layout title="Crear usuario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],
    [
        'name' => 'Crear usuario',
    ],
]">
    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.users.index') }}">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </x-wire-button>
    </x-slot>

    <x-wire-card>
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <x-wire-input
                    label="Nombre"
                    name="name"
                    placeholder="Nombre completo"
                    value="{{ old('name') }}"
                    autocomplete="name"
                />

                <x-wire-input
                    label="Correo"
                    name="email"
                    type="email"
                    placeholder="correo@ejemplo.com"
                    value="{{ old('email') }}"
                    autocomplete="username"
                />

                <div>
                    <x-label for="role_id" value="Rol" />
                    <select
                        id="role_id"
                        name="role_id"
                        class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200"
                    >
                        <option value="">Selecciona un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="role_id" class="mt-2" />
                </div>

                <div class="hidden md:block"></div>

                <x-wire-input
                    label="Contrasena"
                    name="password"
                    type="password"
                    placeholder="Contrasena segura"
                    autocomplete="new-password"
                />

                <x-wire-input
                    label="Confirmar contrasena"
                    name="password_confirmation"
                    type="password"
                    placeholder="Confirma la contrasena"
                    autocomplete="new-password"
                />
            </div>

            <div class="flex justify-end">
                <x-wire-button type="submit" blue>
                    Guardar usuario
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>
