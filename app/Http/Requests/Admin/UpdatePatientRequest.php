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
            'allergies' => ['nullable', 'string', 'max:255'],
            'chronic_conditions' => ['nullable', 'string', 'max:255'],
            'surgical_history' => ['nullable', 'string', 'max:255'],
            'family_history' => ['nullable', 'string', 'max:255'],
            'observations' => ['nullable', 'string', 'max:255'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'emergency_contact_relationship' => ['nullable', 'string', 'max:50'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'blood_type_id.exists' => 'El tipo de sangre seleccionado no es valido.',
            'allergies.max' => 'El campo alergias conocidas no debe ser mayor que 255 caracteres.',
            'chronic_conditions.max' => 'El campo enfermedades crónicas no debe ser mayor que 255 caracteres.',
            'surgical_history.max' => 'El campo antecedentes quirúrgicos no debe ser mayor que 255 caracteres.',
            'family_history.max' => 'El campo antecedentes familiares no debe ser mayor que 255 caracteres.',
            'observations.max' => 'El campo observaciones no debe ser mayor que 255 caracteres.',
            'emergency_contact_name.max' => 'El campo nombre de contacto no debe ser mayor que 255 caracteres.',
            'emergency_contact_phone.max' => 'El campo teléfono de contacto no debe ser mayor que 20 caracteres.',
            'emergency_contact_relationship.max' => 'El campo relación del contacto no debe ser mayor que 50 caracteres.',
        ];
    }
}
