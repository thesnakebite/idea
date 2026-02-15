<?php

use Illuminate\Support\Facades\Auth;

test('registeres a users ', function () {
    visit('/register')
        ->fill('name', 'Jacobo Grinberg')
        ->fill('email', 'jacobo@gmail.com')
        ->fill('password', 'password123!@#')
        ->click('Create Account')
        ->assertPathIs('/ideas');

    $this->assertAuthenticated();

    expect(Auth::user())->toMatchArray([
        'name' => 'Jacobo Grinberg',
        'email' => 'jacobo@gmail.com',
    ]);
});

it('requires a valid email', function () {
    visit('/register')
        ->fill('name', 'Jacobo Grinberg')
        ->fill('email', 'jacobo@gmail.com')
        ->fill('password', 'password123!@#')
        ->click('Create Account')
        ->assertPathIs('/ideas');
});
