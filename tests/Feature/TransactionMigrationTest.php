<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('The transactions table has expected columns.', function () {
    expect(Schema::hasTable('transactions'))->toBeTrue();

    expect(Schema::hasColumns('transactions', [
        'id',
        'sender_id',
        'receiver_id',
        'amount',
        'status',
        'created_at',
        'updated_at',
    ]));
});
