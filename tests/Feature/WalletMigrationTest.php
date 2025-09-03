<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('The wallets table has expected columns.', function () {
    expect(Schema::hasTable('wallets'))->toBeTrue();

    expect(Schema::hasColumns('wallets', [
        'id',
        'user_id',
        'balance',
        'created_at',
        'updated_at',
    ]));
});
