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
            @include('admin.users.form', [
                'action' => route('admin.users.store'),
                'roles' => $roles,
                'selectedRoleId' => old('role_id'),
                'submitLabel' => 'Guardar usuario',
            ])
        </x-wire-card>
    </div>
</x-admin-layout>
