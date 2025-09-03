<?php

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Transaction factory creates valid record', function () {
    $transaction = Transaction::factory()->create();

    expect($transaction->id)->not->toBeNull()
        ->and($transaction->amount)->toBeFloat()
        ->and($transaction->sender)->not->toBeNull()
        ->and($transaction->receiver)->not->toBeNull();
});
