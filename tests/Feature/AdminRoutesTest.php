<?php

use App\Models\User;

it('redirects guests from the admin dashboard', function () {
    $this->get('/admin')
        ->assertRedirect('/login');
});

it('shows the admin dashboard for authenticated users', function () {
    $this->actingAs(User::factory()->create());

    $this->get('/admin')
        ->assertOk()
        ->assertSee('Hola desde admin');
});
