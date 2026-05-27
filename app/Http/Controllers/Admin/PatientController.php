<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePatientRequest;
use App\Models\BloodType;
use App\Models\Patient;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.patients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $bloodTypes = BloodType::all();

        return view('admin.patients.edit', compact('patient', 'bloodTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Paciente actualizado!',
            'text' => 'Los datos del paciente han sido guardados correctamente.',
        ]);

        return redirect()->route('admin.patients.edit', $patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
