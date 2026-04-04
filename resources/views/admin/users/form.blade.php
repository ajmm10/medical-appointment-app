@php
    $isEditing = isset($user);
@endphp

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div class="grid gap-6 md:grid-cols-2">
        <div class="space-y-2">
            <x-wire-input
                label="Nombre"
                name="name"
                placeholder="Nombre completo"
                value="{{ old('name', $user->name ?? '') }}"
                autocomplete="name"
                required
            />

            <p class="text-xs leading-5 text-slate-500">
                Este nombre se mostrara en la tabla y en el panel administrativo.
            </p>
        </div>

        <div class="space-y-2">
            <x-wire-input
                label="Correo"
                name="email"
                type="email"
                placeholder="correo@ejemplo.com"
                value="{{ old('email', $user->email ?? '') }}"
                autocomplete="email"
                required
            />

            <p class="text-xs leading-5 text-slate-500">
                Usa un correo unico para el acceso y recuperacion de la cuenta.
            </p>
        </div>

        <div class="space-y-2">
            <div>
                <x-label for="role_id" value="Rol" />
                <select
                    id="role_id"
                    name="role_id"
                    required
                    class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-100"
                >
                    <option value="">Selecciona un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected((string) old('role_id', $selectedRoleId ?? '') === (string) $role->id)>{{ $role->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="role_id" class="mt-2" />
            </div>

            <p class="text-xs leading-5 text-slate-500">
                Define el perfil inicial que se reflejara en la datatable de usuarios.
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 md:col-span-2">
            <div class="space-y-1">
                <h2 class="text-base font-semibold text-slate-900">Credenciales de acceso</h2>
                <p class="text-sm text-slate-500">
                    {{ $isEditing ? 'Si dejas estos campos vacios, la contrasena actual se conserva.' : 'Asigna una contrasena temporal y comparte el acceso por un canal seguro.' }}
                </p>
            </div>

            <div class="mt-4 grid gap-6 md:grid-cols-2">
                <div class="space-y-2">
                    <x-wire-input
                        label="Contrasena"
                        name="password"
                        type="password"
                        placeholder="{{ $isEditing ? 'Nueva contrasena opcional' : 'Contrasena segura' }}"
                        autocomplete="new-password"
                        :required="! $isEditing"
                    />

                    <p class="text-xs leading-5 text-slate-500">
                        El navegador no autocompletara credenciales previas en este campo.
                    </p>
                </div>

                <div class="space-y-2">
                    <x-wire-input
                        label="Confirmar contrasena"
                        name="password_confirmation"
                        type="password"
                        placeholder="{{ $isEditing ? 'Confirma la nueva contrasena' : 'Confirma la contrasena' }}"
                        autocomplete="new-password"
                        :required="! $isEditing"
                    />

                    <p class="text-xs leading-5 text-slate-500">
                        Confirma la contrasena para validar el alta antes de guardar.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <x-wire-button type="submit" blue>
            {{ $submitLabel }}
        </x-wire-button>
    </div>
</form>
