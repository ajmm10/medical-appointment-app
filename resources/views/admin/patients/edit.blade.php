<x-admin-layout title="Pacientes" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pacientes',
        'href' => route('admin.patients.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">
    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.patients.index') }}">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </x-wire-button>
    </x-slot>


</x-admin-layout>
