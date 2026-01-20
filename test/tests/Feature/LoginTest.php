<?php

use App\Models\User;

test('can view login page', function () {
    visit(route('login'))
        ->assertSee('Log in to your account')
        ->assertSee('Email address')
        ->assertSee('Password');
});

test('can login with correct credentials', function () {

        $user = User::factory()->create([
        'email' => 'patty@granados.com',
        'password' => bcrypt('patty1234'),
    ]);

    visit(route('login'))
        ->type('email', 'patty@granados.com')
        ->type('password', 'patty1234')
        ->press('Log in')
        ->assertPathIs('/dashboard');
});

test('cant login with incorrect password', function () {

    $user = User::factory()->create([
        'email' => 'patty@granados.com',
        'password' => bcrypt('patty1234'),
    ]);

    visit(route('login'))
        ->type('email', 'patty@granados.com')
        ->type('password', 'patty4321')
        ->press('Log in')
        ->assertSee('These credentials do not match our records');
});

test('cant login without email', function () {
    visit(route('login'))
        ->type('password', 'patty1234')
        ->press('Log in')
        ->assertPathIs(path: '/login');
});

test('cant login without password', function () {
    visit(route('login'))
        ->type('email', 'patty@granados.com')
        ->press('Log in')
        ->assertPathIs(path: '/login');
});
