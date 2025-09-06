<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('should not allow merchant-type users to initiate a transfer', function () {
    $merchantUser = \App\Models\User::factory()->create(['type' => \App\Enums\UserType::Merchant]);
    $commonUser = \App\Models\User::factory()->create(['type' => \App\Enums\UserType::Common]);

    $transferService = app()->make(\App\Services\Interfaces\TransferServiceInterface::class);

    $transferData = new \App\DTOs\TransferData(
        senderId: $merchantUser->id,
        receiverId: $commonUser->id,
        amount: 100
    );

    $transferService->transfer($transferData);
})->throws(\App\Exceptions\MerchantCannotTransferException::class);

it('should block the transfer if the sender has insufficient balance.', function () {
    $sender = \App\Models\User::factory()->create(['type' => \App\Enums\UserType::Common]);
    $sender->wallet()->create(['balance' => 0]);
    $receiver = \App\Models\User::factory()->create(['type' => \App\Enums\UserType::Common]);

    $transferService = app()->make(\App\Services\Interfaces\TransferServiceInterface::class);

    $transferData = new \App\DTOs\TransferData(
        senderId: $sender->id,
        receiverId: $receiver->id,
        amount: 100
    );

    $transferService->transfer($transferData);
})->throws(\App\Exceptions\InsufficientFundsException::class);

it('should block the transfer if authorization fails.', function () {
    $sender = \App\Models\User::factory()->create(['type' => \App\Enums\UserType::Common]);
    $sender->wallet()->create(['balance' => 1000]);
    $receiver = \App\Models\User::factory()->create(['type' => \App\Enums\UserType::Common]);
    $authorizeServiceMock = Mockery::mock(\App\Services\Interfaces\AuthorizeServiceInterface::class);

    $authorizeServiceMock->shouldReceive('authorize')
        ->once()
        ->andReturn(false);

    app()->instance(\App\Services\Interfaces\AuthorizeServiceInterface::class, $authorizeServiceMock);

    $transferService = app()->make(\App\Services\Interfaces\TransferServiceInterface::class);

    $transferData = new \App\DTOs\TransferData(
        senderId: $sender->id,
        receiverId: $receiver->id,
        amount: 100
    );

    $transferService->transfer($transferData);
})->throws(\App\Exceptions\TransactionCannotBeAuthorizedException::class);

it('should block the transfer if senderReceived fails.', function () {
    $sender = \App\Models\User::factory()->create(['type' => \App\Enums\UserType::Common]);
    $sender->wallet()->create(['balance' => 1000]);
    $receiver = \App\Models\User::factory()->create(['type' => \App\Enums\UserType::Common]);
    $receiver->wallet()->create(['balance' => 0]);

    $authorizeServiceMock = Mockery::mock(\App\Services\Interfaces\AuthorizeServiceInterface::class);
    $authorizeServiceMock->shouldReceive('authorize')
        ->once()
        ->andReturn(true);

    app()->instance(\App\Services\Interfaces\AuthorizeServiceInterface::class, $authorizeServiceMock);

    $userRepositoryMock = Mockery::mock(\App\Repositories\Interfaces\UserRepositoryInterface::class);
    $userRepositoryMock->shouldReceive('findWithWallet')
        ->with($sender->id)
        ->once()
        ->andReturn($sender);
    $userRepositoryMock->shouldReceive('findWithWallet')
        ->with($receiver->id)
        ->once()
        ->andReturn($receiver);
    $userRepositoryMock->shouldReceive('updateBalance')
        ->twice()
        ->andReturn(false, true);

    app()->instance(\App\Repositories\Interfaces\UserRepositoryInterface::class, $userRepositoryMock);

    $transferService = app()->make(\App\Services\Interfaces\TransferServiceInterface::class);

    $transferData = new \App\DTOs\TransferData(
        senderId: $sender->id,
        receiverId: $receiver->id,
        amount: 100
    );

    $transferService->transfer($transferData);
})->throws(\App\Exceptions\ErrorUpdatingBalanceException::class);

it('should be successful when all conditions are met', function () {
    Event::fake();

    $sender = \App\Models\User::factory()->create(['type' => \App\Enums\UserType::Common]);
    $sender->wallet()->create(['balance' => 1000]);
    $receiver = \App\Models\User::factory()->create(['type' => \App\Enums\UserType::Merchant]);
    $receiver->wallet()->create(['balance' => 0]);

    $authorizeServiceMock = Mockery::mock(\App\Services\Interfaces\AuthorizeServiceInterface::class);
    $authorizeServiceMock->shouldReceive('authorize')
        ->once()
        ->andReturn(true);

    app()->instance(\App\Services\Interfaces\AuthorizeServiceInterface::class, $authorizeServiceMock);

    $transferService = app()->make(\App\Services\Interfaces\TransferServiceInterface::class);

    $transferData = new \App\DTOs\TransferData(
        senderId: $sender->id,
        receiverId: $receiver->id,
        amount: 100
    );

    $transaction = $transferService->transfer($transferData);

    expect($transaction)->toBeInstanceOf(\App\Models\Transaction::class);
    expect($transaction->status)->toBe(\App\Enums\TransactionStatus::Completed);
    expect($transaction->amount)->toEqual(100);

    Event::assertDispatched(\App\Events\TransactionCompleted::class, fn ($event) => $event->transaction->id === $transaction->id);
});
