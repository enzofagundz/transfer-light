<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('User factory creates valid record', function () {
    $user = User::factory()->create();

    expect($user->id)->not->toBeNull()
        ->and($user->name)->not->toBeNull()
        ->and($user->email)->not->toBeNull();
});
