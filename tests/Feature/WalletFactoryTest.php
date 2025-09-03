<?php

use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Wallet factory creates valid record', function () {
    $wallet = Wallet::factory()->create();

    expect($wallet->id)->not->toBeNull()
        ->and($wallet->balance)->toBeFloat()
        ->and($wallet->user)->not->toBeNull();
});
