<?php

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

it('should return all users except merchant-type users', function () {
    $merchantUser = User::factory()->create(['type' => \App\Enums\UserType::Merchant]);
    $commonUser = User::factory()->create(['type' => \App\Enums\UserType::Common]);

    $userRepository = app(UserRepositoryInterface::class);

    $eligibleSenders = $userRepository->getEligibleSenders();

    expect($eligibleSenders->contains('id', $merchantUser->id))->toBeFalse();
    expect($eligibleSenders->contains('id', $commonUser->id))->toBeTrue();
});

it('should create an user with a wallet', function () {
    $userRepository = app(UserRepositoryInterface::class);

    $userRepository->createUserWithWallet([
        'name' => 'John Doe',
        'email' => '8q0Tt@example.com',
        'password' => 'password',
        'cpf_cnpj' => '12345678901',
        'type' => \App\Enums\UserType::Common,
        'balance' => 100.00,
    ]);

    $user = User::where('email', '8q0Tt@example.com')->first();

    expect($user)->not->toBeNull();
    expect($user->wallet)->not->toBeNull();
    expect($user->wallet->balance)->toEqual(100.00);
});

it('should delete an user and its wallet', function () {
    $user = User::factory()->create();
    $wallet = $user->wallet()->create(['balance' => 100.00]);

    $userRepository = app(UserRepositoryInterface::class);

    $userRepository->deleteUserAndWallet($user);

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
    $this->assertDatabaseMissing('wallets', ['id' => $wallet->id]);
});
