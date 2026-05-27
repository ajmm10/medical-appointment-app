<x-admin-layout title="Editar" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Pacientes',  'href' => route('admin.patients.index')],
    ['name' => 'Editar'],
]">
    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Encabezado --}}
        <x-wire-card class="mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-purple-500 flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-xl select-none">
                            {{ strtoupper(substr($patient->user->name, 0, 1)) }}{{ strtoupper(substr($patient->user->name, strrpos($patient->user->name, ' ') + 1, 1)) }}
                        </span>
                    </div>
                    <p class="text-xl font-bold text-gray-900">{{ $patient->user->name }}</p>
                </div>

                <div class="flex gap-3">
                    <x-wire-button flat href="{{ route('admin.patients.index') }}">
                        Volver
                    </x-wire-button>
                    <x-wire-button primary type="submit" icon="check">
                        Guardar cambios
                    </x-wire-button>
                </div>
            </div>
        </x-wire-card>

        <x-wire-card>
            @php
                $antecedentesErrors  = $errors->hasAny(['allergies', 'chronic_conditions', 'surgical_history', 'family_history']);
                $informacionErrors   = $errors->hasAny(['blood_type_id', 'observations']);
                $emergenciaErrors    = $errors->hasAny(['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship']);

                $activeTab = 'datos-personales';
                if ($antecedentesErrors) {
                    $activeTab = 'antecedentes';
                } elseif ($informacionErrors) {
                    $activeTab = 'informacion-general';
                } elseif ($emergenciaErrors) {
                    $activeTab = 'contacto-emergencia';
                }
            @endphp

            <div x-data="{ tab: @js($activeTab) }">

                {{-- Navegación de pestañas --}}
                <div class="border-b border-gray-200 mb-6">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
                        <li class="mr-2">
                            <a href="#" @click.prevent="tab = 'datos-personales'"
                               :class="tab === 'datos-personales' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300'"
                               class="inline-flex items-center gap-2 p-4 border-b-2 rounded-t-lg">
                                <i class="fa-solid fa-user"></i>
                                Datos personales
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="#" @click.prevent="tab = 'antecedentes'"
                               :class="tab === 'antecedentes' ? '{{ $antecedentesErrors ? 'border-red-500 text-red-600' : 'border-blue-600 text-blue-600' }}' : '{{ $antecedentesErrors ? 'border-transparent text-red-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}'"
                               class="inline-flex items-center gap-2 p-4 border-b-2 rounded-t-lg">
                                <i class="fa-solid fa-notes-medical"></i>
                                Antecedentes
                                @if ($antecedentesErrors)
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                @endif
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="#" @click.prevent="tab = 'informacion-general'"
                               :class="tab === 'informacion-general' ? '{{ $informacionErrors ? 'border-red-500 text-red-600' : 'border-blue-600 text-blue-600' }}' : '{{ $informacionErrors ? 'border-transparent text-red-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}'"
                               class="inline-flex items-center gap-2 p-4 border-b-2 rounded-t-lg">
                                <i class="fa-solid fa-circle-info"></i>
                                Información general
                                @if ($informacionErrors)
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                @endif
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="#" @click.prevent="tab = 'contacto-emergencia'"
                               :class="tab === 'contacto-emergencia' ? '{{ $emergenciaErrors ? 'border-red-500 text-red-600' : 'border-blue-600 text-blue-600' }}' : '{{ $emergenciaErrors ? 'border-transparent text-red-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}'"
                               class="inline-flex items-center gap-2 p-4 border-b-2 rounded-t-lg">
                                <i class="fa-solid fa-heart-pulse"></i>
                                Contacto de emergencia
                                @if ($emergenciaErrors)
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Tab 1: Datos Personales --}}
                <div x-show="tab === 'datos-personales'">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fa-solid fa-user-gear text-blue-500 text-xl mt-1"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-blue-800">Edición de cuenta de usuario</h3>
                                    <div class="mt-1 text-sm text-blue-600">
                                        <p>La <strong>información de acceso</strong> (Nombre, email y contraseña)
                                            debe gestionarse desde la cuenta de usuario asociada.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <x-wire-button primary sm href="{{ route('admin.users.edit', $patient->user) }}" target="_blank">
                                    Editar usuario
                                    <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                                </x-wire-button>
                            </div>
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-2 gap-4">
                        <div>
                            <span class="text-gray-500 font-semibold">Teléfono:</span>
                            <span class="text-gray-900 text-sm ml-1">{{ $patient->user->phone }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 font-semibold">Email:</span>
                            <span class="text-gray-900 text-sm ml-1">{{ $patient->user->email }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 font-semibold">Dirección:</span>
                            <span class="text-gray-900 text-sm ml-1">{{ $patient->user->address }}</span>
                        </div>
                    </div>
                </div>

                {{-- Tab 2: Antecedentes Médicos --}}
                <div x-show="tab === 'antecedentes'" style="display: none;">
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div>
                            <x-wire-textarea label="Alergias conocidas" name="allergies">
                                {{ old('allergies', $patient->allergies) }}
                            </x-wire-textarea>
                        </div>
                        <div>
                            <x-wire-textarea label="Enfermedades crónicas" name="chronic_conditions">
                                {{ old('chronic_conditions', $patient->chronic_conditions) }}
                            </x-wire-textarea>
                        </div>
                        <div>
                            <x-wire-textarea label="Antecedentes quirúrgicos" name="surgical_history">
                                {{ old('surgical_history', $patient->surgical_history) }}
                            </x-wire-textarea>
                        </div>
                        <div>
                            <x-wire-textarea label="Antecedentes familiares" name="family_history">
                                {{ old('family_history', $patient->family_history) }}
                            </x-wire-textarea>
                        </div>
                    </div>
                </div>

                {{-- Tab 3: Información General --}}
                <div x-show="tab === 'informacion-general'" style="display: none;">
                    <x-wire-native-select label="Tipo de Sangre" class="mb-4" name="blood_type_id">
                        <option value="">Selecciona un tipo de sangre</option>
                        @foreach($bloodTypes as $bloodType)
                            <option value="{{ $bloodType->id }}" @selected(old('blood_type_id', $patient->blood_type_id) == $bloodType->id)>
                                {{ $bloodType->name }}
                            </option>
                        @endforeach
                    </x-wire-native-select>
                    <x-wire-textarea label="Observaciones" name="observations">
                        {{ old('observations', $patient->observations) }}
                    </x-wire-textarea>
                </div>

                {{-- Tab 4: Contacto de Emergencia --}}
                <div x-show="tab === 'contacto-emergencia'" style="display: none;">
                    <div class="space-y-4">
                        <x-wire-input label="Nombre de contacto" name="emergency_contact_name"
                                      value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" />
                        <x-wire-phone label="Teléfono de contacto" name="emergency_contact_phone"
                                      mask="(###) ###-####" placeholder="(999) 999-9999"
                                      value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" />
                        <x-wire-input label="Relación con el contacto" name="emergency_contact_relationship"
                                      placeholder="Familiar, amigo, etc."
                                      value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" />
                    </div>
                </div>

            </div>
        </x-wire-card>
    </form>
</x-admin-layout>
