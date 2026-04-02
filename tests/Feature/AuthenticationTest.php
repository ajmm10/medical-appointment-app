<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/admin');
});

test('login screen includes a csrf token field', function () {
    $response = $this->get('/login');

    $response->assertOk()
        ->assertSee('name="_token"', false);
});

test('users cannot authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('login route uses the web middleware group', function () {
    expect(Route::getRoutes()->getByName('login')->gatherMiddleware())
        ->toContain('web');
});
