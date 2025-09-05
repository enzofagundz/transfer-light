<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('TransactionServiceInterface can be resolved from the container', function () {
    $service = app()->make(\App\Services\Interfaces\TransactionServiceInterface::class);
    $this->assertInstanceOf(\App\Services\TransactionService::class, $service);
});

test('TransactionServiceInterface can store a transcation', function () {
    $service = app()->make(\App\Services\Interfaces\TransactionServiceInterface::class);

    $sender = \App\Models\User::factory()->create();
    $receiver = \App\Models\User::factory()->create();

    $data = [
        'sender_id' => $sender->id,
        'receiver_id' => $receiver->id,
        'amount' => 100,
        'status' => 0,
    ];

    $transaction = $service->store($data);

    expect($transaction)->not->toBeNull();
    expect($transaction)->toBeInstanceOf(\App\Models\Transaction::class);
    expect($transaction->sender_id)->toBe($data['sender_id']);
    expect($transaction->receiver_id)->toBe($data['receiver_id']);
    expect($transaction->amount)->toBe($data['amount']);
    expect($transaction->status->value)->toBe($data['status']);
});

test('TransactionServiceInterface can update a transaction', function () {
    $service = app()->make(\App\Services\Interfaces\TransactionServiceInterface::class);

    $transaction = \App\Models\Transaction::factory()->create();

    $data = [
        'status' => 1,
    ];

    $updatedTransaction = $service->update($transaction->id, $data);
    expect($updatedTransaction)->not->toBeNull();
    expect($updatedTransaction)->toBeBool(true);
});

test('TransactionServiceInterface can delete a transaction', function () {
    $service = app()->make(\App\Services\Interfaces\TransactionServiceInterface::class);

    $transaction = \App\Models\Transaction::factory()->create();

    $deleted = $service->destroy($transaction->id);
    expect($deleted)->toBeTrue();
    $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
});

test('TransactionServiceInterface can get a transaction', function () {
    $service = app()->make(\App\Services\Interfaces\TransactionServiceInterface::class);

    $transaction = \App\Models\Transaction::factory()->create();

    $foundTransaction = $service->get($transaction->id);
    expect($foundTransaction)->not->toBeNull();
    expect($foundTransaction)->toBeInstanceOf(\App\Models\Transaction::class);
    expect($foundTransaction->id)->toBe($transaction->id);
});

test('TransactionServiceInterface can get all transactions', function () {
    $service = app()->make(\App\Services\Interfaces\TransactionServiceInterface::class);

    \App\Models\Transaction::factory()->count(3)->create();

    $transactions = $service->all();
    expect($transactions)->not->toBeNull();
    expect($transactions)->toBeInstanceOf(\Illuminate\Database\Eloquent\Collection::class);
    expect($transactions->count())->toBe(3);
});
