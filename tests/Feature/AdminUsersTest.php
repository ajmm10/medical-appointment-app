<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

it('redirects guests from admin user pages', function () {
    $this->get('/admin/users')
        ->assertRedirect('/login');

    $this->get('/admin/users/create')
        ->assertRedirect('/login');

    $user = User::factory()->create();

    $this->get(route('admin.users.edit', $user))
        ->assertRedirect('/login');
});

it('shows the admin users page for authenticated users', function () {
    $admin = User::factory()->create();
    $managedUser = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@test.com',
    ]);

    Role::findOrCreate('Administrador', 'web');
    $managedUser->assignRole('Administrador');

    $this->actingAs($admin);

    $this->get('/admin/users')
        ->assertOk()
        ->assertSee('Usuarios')
        ->assertSee('Tabla de usuarios')
        ->assertSee('Nuevo')
        ->assertSee('Test User')
        ->assertSee('test@test.com')
        ->assertSee('Administrador');
});

it('shows the user creation form for authenticated users', function () {
    $admin = User::factory()->create();
    $role = Role::findOrCreate('Administrador', 'web');

    $this->actingAs($admin);

    $this->get('/admin/users/create')
        ->assertOk()
        ->assertSee('Crear usuario')
        ->assertSee('Credenciales de acceso')
        ->assertSee('Nombre')
        ->assertSee('Correo')
        ->assertSee('Contrasena')
        ->assertSee('Confirmar contrasena')
        ->assertSee('Selecciona un rol')
        ->assertSee($role->name);
});

it('shows the user edit form for authenticated users', function () {
    $admin = User::factory()->create();
    $managedUser = User::factory()->create([
        'name' => 'Usuario Editable',
        'email' => 'editable@demo.com',
    ]);
    $role = Role::findOrCreate('Recepcionista', 'web');

    $managedUser->assignRole($role);

    $this->actingAs($admin);

    $this->get(route('admin.users.edit', $managedUser))
        ->assertOk()
        ->assertSee('Editar usuario')
        ->assertSee('Usuario Editable')
        ->assertSee('editable@demo.com')
        ->assertSee($role->name);
});

it('stores a user with the selected role', function () {
    $admin = User::factory()->create();
    $role = Role::findOrCreate('Recepcionista', 'web');

    $this->actingAs($admin);

    $this->post(route('admin.users.store'), [
        'name' => 'Nuevo Usuario',
        'email' => 'nuevo@demo.com',
        'role_id' => $role->id,
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('swal', function (array $swal): bool {
            return $swal['icon'] === 'success'
                && $swal['title'] === 'Usuario creado'
                && $swal['text'] === 'El usuario fue registrado correctamente';
        });

    $this->assertDatabaseHas('users', [
        'name' => 'Nuevo Usuario',
        'email' => 'nuevo@demo.com',
    ]);

    $createdUser = User::query()->where('email', 'nuevo@demo.com')->firstOrFail();

    expect($createdUser->hasRole($role))->toBeTrue();
});

it('validates required fields when storing a user', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin);

    $this->post(route('admin.users.store'), [
        'name' => 'Usuario 123',
        'email' => 'correo-invalido',
        'role_id' => '',
        'password' => 'password',
        'password_confirmation' => 'diferente',
    ])->assertSessionHasErrors(['name', 'email', 'role_id', 'password']);
});

it('rejects duplicate emails when storing a user', function () {
    $admin = User::factory()->create();
    User::factory()->create([
        'email' => 'duplicado@demo.com',
    ]);
    $role = Role::findOrCreate('Recepcionista', 'web');

    $this->actingAs($admin);

    $this->post(route('admin.users.store'), [
        'name' => 'Usuario Duplicado',
        'email' => 'duplicado@demo.com',
        'role_id' => $role->id,
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors(['email']);
});

it('updates a user and synchronizes the selected role', function () {
    $admin = User::factory()->create();
    $managedUser = User::factory()->create([
        'name' => 'Usuario Original',
        'email' => 'original@demo.com',
    ]);
    $oldRole = Role::findOrCreate('Recepcionista', 'web');
    $newRole = Role::findOrCreate('Doctor', 'web');

    $managedUser->assignRole($oldRole);

    $this->actingAs($admin);

    $this->put(route('admin.users.update', $managedUser), [
        'name' => 'Usuario Actualizado',
        'email' => 'actualizado@demo.com',
        'role_id' => $newRole->id,
        'password' => '',
        'password_confirmation' => '',
    ])->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('swal', function (array $swal): bool {
            return $swal['icon'] === 'success'
                && $swal['title'] === 'Usuario actualizado'
                && $swal['text'] === 'El usuario fue modificado correctamente';
        });

    $managedUser->refresh();

    expect($managedUser->name)->toBe('Usuario Actualizado');
    expect($managedUser->email)->toBe('actualizado@demo.com');
    expect($managedUser->hasRole($newRole))->toBeTrue();
    expect($managedUser->hasRole($oldRole))->toBeFalse();
});

it('deletes another user and clears role assignments', function () {
    $admin = User::factory()->create();
    $managedUser = User::factory()->create();
    $role = Role::findOrCreate('Administrador', 'web');

    $managedUser->assignRole($role);

    $this->actingAs($admin);

    $this->delete(route('admin.users.destroy', $managedUser))
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('swal', function (array $swal): bool {
            return $swal['icon'] === 'success'
                && $swal['title'] === 'Usuario eliminado'
                && $swal['text'] === 'El usuario fue eliminado correctamente';
        });

    $this->assertDatabaseMissing('users', [
        'id' => $managedUser->id,
    ]);

    $this->assertDatabaseMissing(config('permission.table_names.model_has_roles'), [
        'model_id' => $managedUser->id,
        'model_type' => User::class,
        'role_id' => $role->id,
    ]);
});

it('protects admin user deletion with the web and auth middleware stack', function () {
    expect(Route::getRoutes()->getByName('admin.users.destroy')->gatherMiddleware())
        ->toBe([
            'web',
            'auth:sanctum',
            'Laravel\\Jetstream\\Http\\Middleware\\AuthenticateSession',
            'verified',
        ]);
});

it('protects admin user creation with the web and auth middleware stack', function () {
    expect(Route::getRoutes()->getByName('admin.users.store')->gatherMiddleware())
        ->toBe([
            'web',
            'auth:sanctum',
            'Laravel\\Jetstream\\Http\\Middleware\\AuthenticateSession',
            'verified',
        ]);
});

it('forbids deleting the authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $this->delete(route('admin.users.destroy', $user))
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('swal', function (array $swal): bool {
            return $swal['icon'] === 'error'
                && $swal['title'] === 'Usuario protegido'
                && $swal['text'] === 'No puedes eliminar tu propia cuenta.';
        });
});

it('forbids deleting the principal administrator', function () {
    $admin = User::factory()->create();
    $principalAdmin = User::factory()->create([
        'email' => 'test@test.com',
    ]);
    $principalAdmin->assignRole(Role::findOrCreate('Super administrador', 'web'));

    $this->actingAs($admin);

    $this->delete(route('admin.users.destroy', $principalAdmin))
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('swal', function (array $swal): bool {
            return $swal['icon'] === 'error'
                && $swal['title'] === 'Usuario protegido'
                && $swal['text'] === 'No puedes eliminar al administrador principal.';
        });
});

it('protects admin user edit and update with the web and auth middleware stack', function () {
    expect(Route::getRoutes()->getByName('admin.users.edit')->gatherMiddleware())
        ->toBe([
            'web',
            'auth:sanctum',
            'Laravel\\Jetstream\\Http\\Middleware\\AuthenticateSession',
            'verified',
        ]);

    expect(Route::getRoutes()->getByName('admin.users.update')->gatherMiddleware())
        ->toBe([
            'web',
            'auth:sanctum',
            'Laravel\\Jetstream\\Http\\Middleware\\AuthenticateSession',
            'verified',
        ]);
});
