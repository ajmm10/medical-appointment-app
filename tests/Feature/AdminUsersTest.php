<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

it('redirects guests from admin user pages', function () {
    $this->get('/admin/users')
        ->assertRedirect('/login');

    $this->get('/admin/users/create')
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
        ->assertSee('Nombre')
        ->assertSee('Correo')
        ->assertSee('Contrasena')
        ->assertSee('Confirmar contrasena')
        ->assertSee('Selecciona un rol')
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
        'name' => '',
        'email' => 'correo-invalido',
        'role_id' => '',
        'password' => 'password',
        'password_confirmation' => 'diferente',
    ])->assertSessionHasErrors(['name', 'email', 'role_id', 'password']);
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
        ->assertForbidden()
        ->assertSeeText('YOU CANNOT DELETE YOURSELF.');
});
