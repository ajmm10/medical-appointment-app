<x-admin-layout title="Usuarios" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
    ],
    ]">
    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.users.create') }}">
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-center">
                <div class="space-y-2">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">
                        Gestion de usuarios
                    </p>
                    <h2 class="text-2xl font-semibold text-slate-900">
                        Administra el acceso al panel desde una sola pantalla
                    </h2>
                    <p class="max-w-2xl text-sm leading-6 text-slate-600">
                        Consulta los usuarios registrados, identifica su rol actual y crea nuevas cuentas con un flujo de alta claro y consistente con el resto del modulo administrativo.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Lectura</p>
                        <p class="mt-2 text-sm font-medium text-slate-900">Tabla con nombre, correo y roles</p>
                    </div>

                    <div class="rounded-xl border border-sky-100 bg-sky-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">Insercion</p>
                        <p class="mt-2 text-sm font-medium text-sky-900">Formulario listo para registrar nuevos usuarios</p>
                    </div>
                </div>
            </div>
        </section>

        <x-wire-card>
            <div class="mb-4 space-y-1">
                <h2 class="text-lg font-semibold text-slate-900">Tabla de usuarios</h2>
                <p class="text-sm text-slate-500">
                    La datatable permite buscar rapidamente usuarios y revisar el rol asignado antes de realizar cambios.
                </p>
            </div>

            @livewire('admin.datatables.user-table')
        </x-wire-card>
    </div>
</x-admin-layout>
