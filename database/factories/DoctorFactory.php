<?php

namespace Database\Factories;

use App\Models\Speciality;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'speciality_id' => Speciality::inRandomOrder()->first()?->id,
            'medical_license_number' => fake()->bothify('MED-####??'),
            'biography' => fake()->paragraph(),
        ];
    }
}
