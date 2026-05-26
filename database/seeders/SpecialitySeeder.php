<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $specialities = [
        'Cardiología', 'Pediatría', 'Dermatología',
        'Neurología', 'Ortopedia', 'Ginecología',
        'Oftalmología', 'Psiquiatría',
    ];

    foreach ($specialities as $name) {
        \App\Models\Speciality::create(['name' => $name]);
    }
}
}
