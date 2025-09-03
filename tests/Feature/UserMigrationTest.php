<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('The users table has expected columns.', function () {
    expect(Schema::hasTable('users'))->toBeTrue();

    expect(Schema::hasColumns('users', [
        'id',
        'name',
        'email',
        'password',
        'cpf_cnpj',
        'type',
        'email_verified_at',
        'created_at',
        'updated_at',
    ]));
});
