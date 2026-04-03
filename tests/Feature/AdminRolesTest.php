<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

it('redirects guests from admin role pages', function () {
    $role = Role::query()->create([
        'name' => 'TempRole',
        'guard_name' => 'web',
    ]);

    $this->get('/admin/roles')
        ->assertRedirect('/login');

    $this->get('/admin/roles/create')
        ->assertRedirect('/login');

    $this->get("/admin/roles/{$role->id}/edit")
        ->assertRedirect('/login');
});

it('shows admin role pages for authenticated users', function () {
    $this->actingAs(User::factory()->create());
    $role = Role::query()->create([
        'name' => 'TempRole',
        'guard_name' => 'web',
    ]);

    $this->get('/admin/roles')
        ->assertOk()
        ->assertSee('Roles')
        ->assertSee('Nuevo');

    $this->get('/admin/roles/create')
        ->assertOk()
        ->assertSee('Crear rol');

    $this->get("/admin/roles/{$role->id}/edit")
        ->assertOk()
        ->assertSee('Editar')
        ->assertSee(route('admin.roles.index'), false);
});

it('renders a csrf token on the admin role creation form', function () {
    $this->actingAs(User::factory()->create());

    $this->get('/admin/roles/create')
        ->assertOk()
        ->assertSee('name="_token"', false);
});

it('stores a role for authenticated users', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->post('/admin/roles', [
        'name' => 'Medico',
    ]);

    $response->assertRedirect(route('admin.roles.index'))
        ->assertSessionHas('swal', function (array $swal): bool {
            return $swal['icon'] === 'success'
                && $swal['title'] === 'Rol creado correctamente'
                && $swal['text'] === 'El rol ha sido creado correctamente';
        });

    $this->assertDatabaseHas('roles', [
        'name' => 'Medico',
        'guard_name' => 'web',
        'is_system' => false,
    ]);
});

it('validates role name when storing a role', function () {
    $this->actingAs(User::factory()->create());
    Role::query()->create([
        'name' => 'Admin',
        'guard_name' => 'web',
    ]);

    $this->post('/admin/roles', [
        'name' => 'Admin',
    ])->assertSessionHasErrors('name');
});

it('updates a role for authenticated users and shows success alert', function () {
    $this->actingAs(User::factory()->create());
    $role = Role::query()->create([
        'name' => 'Paciente',
        'guard_name' => 'web',
        'is_system' => false,
    ]);

    $response = $this->put("/admin/roles/{$role->id}", [
        'name' => 'Pacientey',
    ]);

    $response->assertRedirect(route('admin.roles.index'))
        ->assertSessionHas('swal', function (array $swal): bool {
            return $swal['icon'] === 'success'
                && $swal['title'] === 'Rol actualizado correctamente'
                && $swal['text'] === 'El rol ha sido modificado correctamente';
        });

    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
        'name' => 'Pacientey',
        'guard_name' => 'web',
    ]);
});

it('blocks the edit screen for protected system roles', function () {
    $this->actingAs(User::factory()->create());
    $role = Role::query()->create([
        'name' => 'Rol base',
        'guard_name' => 'web',
        'is_system' => true,
    ]);

    $this->get("/admin/roles/{$role->id}/edit")
        ->assertRedirect(route('admin.roles.index'))
        ->assertSessionHas('swal', function (array $swal): bool {
            return $swal['icon'] === 'error'
                && $swal['title'] === 'Rol protegido'
                && $swal['text'] === 'Los roles del sistema no se pueden editar ni eliminar.';
        });
});

it('prevents updates to protected system roles', function () {
    $this->actingAs(User::factory()->create());
    $role = Role::query()->create([
        'name' => 'Rol base',
        'guard_name' => 'web',
        'is_system' => true,
    ]);

    $this->put("/admin/roles/{$role->id}", [
        'name' => 'Rol modificado',
    ])->assertRedirect(route('admin.roles.index'))
        ->assertSessionHas('swal', function (array $swal): bool {
            return $swal['icon'] === 'error'
                && $swal['title'] === 'Rol protegido'
                && $swal['text'] === 'Los roles del sistema no se pueden editar ni eliminar.';
        });

    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
        'name' => 'Rol base',
        'is_system' => true,
    ]);
});

it('prevents deletion of protected system roles', function () {
    $this->actingAs(User::factory()->create());
    $role = Role::query()->create([
        'name' => 'Rol base',
        'guard_name' => 'web',
        'is_system' => true,
    ]);

    $this->delete("/admin/roles/{$role->id}")
        ->assertRedirect(route('admin.roles.index'))
        ->assertSessionHas('swal', function (array $swal): bool {
            return $swal['icon'] === 'error'
                && $swal['title'] === 'Rol protegido'
                && $swal['text'] === 'Los roles del sistema no se pueden editar ni eliminar.';
        });

    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
        'name' => 'Rol base',
        'is_system' => true,
    ]);
});

it('renders the protected role badge and hides action buttons for system roles', function () {
    $systemRole = Role::query()->create([
        'name' => 'Rol del sistema',
        'guard_name' => 'web',
        'is_system' => true,
    ]);

    $customRole = Role::query()->create([
        'name' => 'Rol editable',
        'guard_name' => 'web',
        'is_system' => false,
    ]);

    $systemBadge = view('admin.roles.protection-badge', ['role' => $systemRole])->render();
    $customBadge = view('admin.roles.protection-badge', ['role' => $customRole])->render();
    $systemActions = view('admin.roles.actions', ['role' => $systemRole])->render();
    $customActions = view('admin.roles.actions', ['role' => $customRole])->render();

    expect($systemBadge)->toContain('Sistema');
    expect($customBadge)->toContain('Personalizado');
    expect($systemActions)->toContain('Protegido');
    expect($systemActions)->not->toContain(route('admin.roles.edit', $systemRole));
    expect($systemActions)->not->toContain(route('admin.roles.destroy', $systemRole));
    expect($customActions)->toContain(route('admin.roles.edit', $customRole));
    expect($customActions)->toContain(route('admin.roles.destroy', $customRole));
});

it('validates role name when updating a role', function () {
    $this->actingAs(User::factory()->create());
    $roleA = Role::query()->create([
        'name' => 'Doctor',
        'guard_name' => 'web',
    ]);
    $roleB = Role::query()->create([
        'name' => 'Recepcionista',
        'guard_name' => 'web',
    ]);

    $this->put("/admin/roles/{$roleB->id}", [
        'name' => $roleA->name,
    ])->assertSessionHasErrors('name');
});
