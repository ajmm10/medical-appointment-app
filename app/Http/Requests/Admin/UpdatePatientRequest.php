<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'blood_type_id' => ['nullable', 'integer', Rule::exists('blood_types', 'id')],
            'allergies' => ['nullable', 'string', 'max:500'],
            'surgical_history' => ['nullable', 'string', 'max:500'],
            'family_medical_history' => ['nullable', 'string', 'max:500'],
            'observations' => ['nullable', 'string', 'max:500'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'emergency_contact_relationship' => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'blood_type_id.exists' => 'El tipo de sangre seleccionado no es valido.',
            'allergies.max' => 'Las alergias no pueden superar los 500 caracteres.',
            'surgical_history.max' => 'Los antecedentes quirurgicos no pueden superar los 500 caracteres.',
            'family_medical_history.max' => 'Los antecedentes familiares no pueden superar los 500 caracteres.',
            'observations.max' => 'Las observaciones no pueden superar los 500 caracteres.',
            'emergency_contact_name.max' => 'El nombre del contacto no puede superar los 255 caracteres.',
            'emergency_contact_phone.max' => 'El telefono no puede superar los 20 caracteres.',
            'emergency_contact_relationship.max' => 'El parentesco no puede superar los 100 caracteres.',
        ];
    }
}
