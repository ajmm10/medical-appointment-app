<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePatientRequest;
use App\Models\BloodType;
use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PatientController extends Controller
{
    public function index(): View
    {
        return view('admin.patients.index');
    }

    public function create(): View
    {
        return view('admin.patients.create');
    }

    public function store(): RedirectResponse
    {
        return redirect()->route('admin.users.create');
    }

    public function show(Patient $patient): View
    {
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient): View
    {
        $patient->loadMissing('user');
        $bloodTypes = BloodType::query()->orderBy('name')->get();

        return view('admin.patients.edit', compact('patient', 'bloodTypes'));
    }

    public function update(UpdatePatientRequest $request, Patient $patient): RedirectResponse
    {
        $patient->update($request->validated());

        return redirect()
            ->route('admin.patients.edit', $patient)
            ->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy(Patient $patient): RedirectResponse
    {
        return redirect()->route('admin.patients.index');
    }
}
