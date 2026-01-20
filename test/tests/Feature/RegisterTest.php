<?php

use App\Models\User;



test('can view register page', function () {
    visit(route('register'))
        ->assertSee('Create an account')
        ->assertSee('Name')
        ->assertSee('Email address')
        ->assertSee('Password')
        ->assertSee('Confirm password');

});


test('new user can register', function () {

    visit(route('register'))
        ->type('name', 'Patty Granados')
        ->type('email', 'patty@granados.com')
        ->type('password', 'patty1234')
        ->type('password_confirmation', 'patty1234')
        ->press('Create account')
        ->assertPathIs('/dashboard');

    $this->assertDatabaseHas('users', [
        'email' => 'patty@granados.com',
        'name' => 'Patty Granados',

    ]);
});

test('cant register without name', function () {
    visit(route('register'))
        ->type('email', 'patty@granados.com')
        ->type('password', 'patty1234')
        ->type('password_confirmation', 'patty1234')
        ->press('Create account')
        ->assertPathIs('/register');
});

test('cant register without email', function () {
    visit(route('register'))
        ->type('name', 'Patty Granados')
        ->type('password', 'patty1234')
        ->type('password_confirmation', 'patty1234')
        ->press('Create account')
        ->assertPathIs(path: '/register');
});

test('cant register without password', function () {
    visit(route('register'))
        ->type('name', 'Patty Granados')
        ->type('email', 'patty@granados.com')
        ->type('password_confirmation', 'patty1234')
        ->press('Create account')
        ->assertPathIs(path: '/register');
});

test('cant register if passwords dont match', function () {
    visit(route('register'))
        ->type('name', 'Patty Granados')
        ->type('email', 'patty@granados.com')
        ->type('password', 'patty1234')
        ->type('password_confirmation', 'patty4567')
        ->press('Create account')
        ->assertSee('The password field confirmation does not match');
});

test('cant register with an email that already exists', function () {

    User::factory()->create([
        'email' => 'patty@granados.com',
    ]);

    visit(route('register'))
        ->type('name', 'Patty Granados')
        ->type('email', 'patty@granados.com')
        ->type('password', 'patty1234')
        ->type('password_confirmation', 'patty1234')
        ->press('Create account')
        ->assertSee('The email has already been taken');
});

