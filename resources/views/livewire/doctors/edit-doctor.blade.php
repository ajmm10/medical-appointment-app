<div>
    {{-- Header con avatar, nombre y botones --}}
    <x-wire-card shadow="md" class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                {{-- Avatar con iniciales --}}
                <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center">
                    <span class="text-indigo-600 font-semibold text-lg">
                        {{ strtoupper(substr($doctor->user->name, 0, 1)) }}{{ strtoupper(substr($doctor->user->name, strrpos($doctor->user->name, ' ') + 1, 1)) }}
                    </span>
                </div>
                <div>
                    <p class="text-lg font-semibold text-gray-800">{{ $doctor->user->name }}</p>
                    <p class="text-sm text-gray-400">Licencia: {{ $doctor->medical_license_number ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex gap-3">
                <x-wire-button label="Volver" href="{{ route('admin.dashboard') }}" flat />
                <x-wire-button label="Guardar cambios" wire:click="save" primary icon="check" />
            </div>
        </div>
    </x-wire-card>

    {{-- Formulario --}}
    <x-wire-card shadow="md">
        @if (session()->has('message'))
            <x-wire-alert title="{{ session('message') }}" positive class="mb-4" />
        @endif

        <div class="flex flex-col gap-5">

            <x-wire-native-select
                label="Especialidad"
                wire:model="speciality_id"
                :error="$errors->first('speciality_id')">
                <option value="">-- Seleccionar especialidad --</option>
                @foreach ($specialities as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </x-wire-native-select>

            <x-wire-input
                label="Número de licencia médica"
                wire:model="medical_license_number"
                placeholder="Ej: 6549876341654654"
                :error="$errors->first('medical_license_number')" />

            <x-wire-textarea
                label="Biografía"
                wire:model="biography"
                placeholder="Descripción del doctor..."
                rows="4"
                :error="$errors->first('biography')" />

        </div>
    </x-wire-card>
</div>
