<div class="mt-6 space-y-6">
    {{-- Medical data --}}
    <div class="space-y-4">
        <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Datos médicos</h3>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <div>
                    <x-label for="blood_type_id" value="Tipo de sangre" />
                    <select
                        id="blood_type_id"
                        name="blood_type_id"
                        class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-100"
                    >
                        <option value="">Sin especificar</option>
                        @foreach ($bloodTypes as $bloodType)
                            <option value="{{ $bloodType->id }}" @selected(old('blood_type_id', $patient->blood_type_id ?? '') == $bloodType->id)>{{ $bloodType->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="blood_type_id" class="mt-2" />
                </div>
            </div>

            <div class="space-y-2">
                <x-wire-input
                    label="Alergias"
                    name="allergies"
                    placeholder="Ej: Penicilina, polvo, mariscos..."
                    value="{{ old('allergies', $patient->allergies ?? '') }}"
                />
            </div>

            <div class="space-y-2">
                <x-wire-input
                    label="Antecedentes quirúrgicos"
                    name="surgical_history"
                    placeholder="Ej: Apendicectomía 2018..."
                    value="{{ old('surgical_history', $patient->surgical_history ?? '') }}"
                />
            </div>

            <div class="space-y-2">
                <x-wire-input
                    label="Antecedentes familiares"
                    name="family_medical_history"
                    placeholder="Ej: Diabetes, hipertensión..."
                    value="{{ old('family_medical_history', $patient->family_medical_history ?? '') }}"
                />
            </div>

            <div class="space-y-2 md:col-span-2">
                <x-wire-input
                    label="Observaciones"
                    name="observations"
                    placeholder="Notas adicionales relevantes..."
                    value="{{ old('observations', $patient->observations ?? '') }}"
                />
            </div>
        </div>
    </div>

    {{-- Emergency contact --}}
    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
        <div class="space-y-1">
            <h3 class="text-base font-semibold text-slate-900">Contacto de emergencia</h3>
            <p class="text-sm text-slate-500">Persona a quien notificar en caso de urgencia.</p>
        </div>

        <div class="mt-4 grid gap-6 md:grid-cols-3">
            <div class="space-y-2">
                <x-wire-input
                    label="Nombre"
                    name="emergency_contact_name"
                    placeholder="Nombre completo"
                    value="{{ old('emergency_contact_name', $patient->emergency_contact_name ?? '') }}"
                />
            </div>

            <div class="space-y-2">
                <x-wire-input
                    label="Teléfono"
                    name="emergency_contact_phone"
                    placeholder="Ej: +52 555 123 4567"
                    value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone ?? '') }}"
                />
            </div>

            <div class="space-y-2">
                <x-wire-input
                    label="Parentesco"
                    name="emergency_contact_relationship"
                    placeholder="Ej: Madre, esposo, hijo..."
                    value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship ?? '') }}"
                />
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <x-wire-button type="submit" blue>
            {{ $submitLabel }}
        </x-wire-button>
    </div>
</div>
