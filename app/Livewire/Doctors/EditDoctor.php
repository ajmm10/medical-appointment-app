<?php

namespace App\Livewire\Doctors;

use App\Models\Doctor;
use App\Models\Speciality;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class EditDoctor extends Component
{
    public Doctor $doctor;
    public $speciality_id;
    public $medical_license_number;
    public $biography;

    public function mount(Doctor $doctor)
    {
        $this->doctor                 = $doctor;
        $this->speciality_id          = $doctor->speciality_id;
        $this->medical_license_number = $doctor->medical_license_number;
        $this->biography              = $doctor->biography;
    }

    protected function rules()
    {
        return [
            'speciality_id'          => 'required|exists:specialities,id',
            'medical_license_number' => 'nullable|string|max:255',
            'biography'              => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->doctor->update([
            'speciality_id'          => $this->speciality_id,
            'medical_license_number' => $this->medical_license_number,
            'biography'              => $this->biography,
        ]);

        session()->flash('message', 'Doctor actualizado correctamente.');
        return redirect()->route('admin.dashboard');
    }

    public function render()
    {
        return view('livewire.doctors.edit-doctor', [
            'specialities' => Speciality::orderBy('name')->get(),
        ]);
    }
}
