<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Interfaces\UserRepositoryInterface;

uses(RefreshDatabase::class);

test('UserRepositoryInterface can find a user with their wallet.', function () {
    $user = User::factory()->create();
    $user->wallet()->create(['balance' => 100.00]);

    $userRepository = app(UserRepositoryInterface::class);
    $foundUser = $userRepository->findWithWallet($user->id);

    expect($foundUser)->not->toBeNull();
    expect($foundUser->wallet)->not->toBeNull();
    expect($foundUser->wallet->balance)->toEqual(100.00);
});

test('UserRepositoryInterface can update a user\'s balance.', function () {
    $user = User::factory()->create();
    $user->wallet()->create(['balance' => 100.00]);

    $userRepository = app(UserRepositoryInterface::class);
    $updated = $userRepository->updateBalance($user, 200.00);

    expect($updated)->toBeTrue();
    expect($user->wallet->balance)->toEqual(200.00);
});
