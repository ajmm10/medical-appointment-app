<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\'-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'role_id' => ['required', 'integer', Rule::exists('roles', 'id')],
            'password' => ['nullable', 'string', Password::default(), 'confirmed'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del usuario es obligatorio.',
            'name.regex' => 'El nombre solo puede contener letras, espacios, apostrofes y guiones.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Debes ingresar un correo valido.',
            'email.unique' => 'Ya existe un usuario con ese correo.',
            'role_id.required' => 'Debes seleccionar un rol.',
            'role_id.exists' => 'El rol seleccionado no es valido.',
            'password.confirmed' => 'La confirmacion de la contrasena no coincide.',
        ];
    }
}
