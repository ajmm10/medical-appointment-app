<?php

use App\Models\Patient;
use App\Models\User;
use Spatie\Permission\Models\Role;

it('redirects guests from admin patient pages', function () {
    $this->get(route('admin.patients.index'))
        ->assertRedirect('/login');

    $this->get(route('admin.patients.create'))
        ->assertRedirect('/login');

    $patient = Patient::factory()->create();

    $this->get(route('admin.patients.edit', $patient))
        ->assertRedirect('/login');
});

it('shows the admin patients index page', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin);

    $this->get(route('admin.patients.index'))
        ->assertOk()
        ->assertSee('Pacientes')
        ->assertSee('Nuevo paciente');
});

it('shows the patients datatable livewire component on index', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin);

    $this->get(route('admin.patients.index'))
        ->assertOk()
        ->assertSeeLivewire(\App\Livewire\Admin\Datatables\PatientTable::class);
});

it('stores a user with Paciente role, creates a patient record, and redirects to edit', function () {
    $admin = User::factory()->create();
    $role = Role::findOrCreate('Paciente', 'web');

    $this->actingAs($admin);

    $response = $this->post(route('admin.users.store'), [
        'name' => 'Maria Lopez',
        'email' => 'maria@demo.com',
        'role_id' => $role->id,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $user = User::query()->where('email', 'maria@demo.com')->firstOrFail();

    $this->assertDatabaseHas('patients', ['user_id' => $user->id]);
    expect($user->hasRole('Paciente'))->toBeTrue();

    $patient = $user->patient;
    $response->assertRedirect(route('admin.patients.edit', $patient));
});

it('stores a non-patient user and redirects to users index without creating a patient', function () {
    $admin = User::factory()->create();
    $role = Role::findOrCreate('Recepcionista', 'web');

    $this->actingAs($admin);

    $this->post(route('admin.users.store'), [
        'name' => 'Carlos Ruiz',
        'email' => 'carlos@demo.com',
        'role_id' => $role->id,
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect(route('admin.users.index'));

    $user = User::query()->where('email', 'carlos@demo.com')->firstOrFail();

    $this->assertDatabaseMissing('patients', ['user_id' => $user->id]);
});

it('shows the patient edit page for authenticated users', function () {
    $admin = User::factory()->create();
    $patient = Patient::factory()->create([
        'user_id' => User::factory()->create([
            'name' => 'Prueba paciente',
            'email' => 'prueba@demo.com',
        ]),
    ]);

    $this->actingAs($admin);

    $this->get(route('admin.patients.edit', $patient))
        ->assertOk()
        ->assertSee('Editar')
        ->assertSee('Prueba paciente')
        ->assertSee('Volver')
        ->assertSee('Guardar cambios')
        ->assertSee('Editar usuario')
        ->assertSee('bg-purple-500', false);
});

it('updates patient medical data and redirects back to edit page', function () {
    $admin = User::factory()->create();
    $patient = Patient::factory()->create();

    $this->actingAs($admin);

    $response = $this->put(route('admin.patients.update', $patient), [
        'allergies' => 'Polen y polvo',
        'chronic_conditions' => 'Hipertensión',
        'surgical_history' => 'Apendicectomía 2015',
        'family_history' => 'Diabetes en abuelos',
        'observations' => 'Paciente colaborador',
        'emergency_contact_name' => 'Ana García',
        'emergency_contact_phone' => '(555) 123-4567',
        'emergency_contact_relationship' => 'Madre',
    ]);

    $response->assertRedirect(route('admin.patients.edit', $patient));

    $this->assertDatabaseHas('patients', [
        'id' => $patient->id,
        'allergies' => 'Polen y polvo',
        'chronic_conditions' => 'Hipertensión',
        'surgical_history' => 'Apendicectomía 2015',
        'family_history' => 'Diabetes en abuelos',
        'observations' => 'Paciente colaborador',
        'emergency_contact_name' => 'Ana García',
        'emergency_contact_relationship' => 'Madre',
    ]);
});

it('rejects invalid blood type on patient update', function () {
    $admin = User::factory()->create();
    $patient = Patient::factory()->create();

    $this->actingAs($admin);

    $this->put(route('admin.patients.update', $patient), [
        'blood_type_id' => 9999,
    ])->assertSessionHasErrors('blood_type_id');
});
