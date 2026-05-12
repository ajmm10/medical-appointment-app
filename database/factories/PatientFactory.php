<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'blood_type_id' => null,
            'allergies' => null,
            'surgical_history' => null,
            'family_medical_history' => null,
            'observations' => null,
            'emergency_contact_name' => null,
            'emergency_contact_phone' => null,
            'emergency_contact_relationship' => null,
        ];
    }
}
