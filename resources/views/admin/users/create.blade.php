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

    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-center">
                <div class="space-y-2">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">
                        Alta de usuarios
                    </p>
                    <h2 class="text-2xl font-semibold text-slate-900">
                        Registra nuevas cuentas con un formulario claro y responsivo
                    </h2>
                    <p class="max-w-2xl text-sm leading-6 text-slate-600">
                        Completa los datos generales, asigna el rol inicial y define credenciales temporales con autocompletado seguro para evitar exponer contrasenas.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Paso 1</p>
                        <p class="mt-2 text-sm font-medium text-slate-900">Captura nombre y correo</p>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Paso 2</p>
                        <p class="mt-2 text-sm font-medium text-slate-900">Selecciona el rol inicial</p>
                    </div>

                    <div class="rounded-xl border border-sky-100 bg-sky-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">Paso 3</p>
                        <p class="mt-2 text-sm font-medium text-sky-900">Configura credenciales seguras</p>
                    </div>
                </div>
            </div>
        </section>

        <x-wire-card>
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-2">
                        <x-wire-input
                            label="Nombre"
                            name="name"
                            placeholder="Nombre completo"
                            value="{{ old('name') }}"
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
                            value="{{ old('email') }}"
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
                                    <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->name }}</option>
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
                                Asigna una contrasena temporal y comparte el acceso por un canal seguro.
                            </p>
                        </div>

                        <div class="mt-4 grid gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <x-wire-input
                                    label="Contrasena"
                                    name="password"
                                    type="password"
                                    placeholder="Contrasena segura"
                                    autocomplete="new-password"
                                    required
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
                                    placeholder="Confirma la contrasena"
                                    autocomplete="new-password"
                                    required
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
                        Guardar usuario
                    </x-wire-button>
                </div>
            </form>
        </x-wire-card>
    </div>
</x-admin-layout>
