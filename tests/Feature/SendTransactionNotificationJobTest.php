<?php

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Transaction notification sending job works', function () {
    $transaction = Transaction::factory()->create();

    Queue::fake();

    \App\Jobs\SendTransactionNotificationJob::dispatch($transaction);

    Queue::assertPushed(\App\Jobs\SendTransactionNotificationJob::class, function ($job) use ($transaction) {
        return $job->transaction->id === $transaction->id;
    });
});

test('Job handles HTTP request failures', function () {
    $transaction = Transaction::factory()->create();

    Http::fake([
        'https://util.devi.tools/api/v1/notify' => Http::response(null, 500),
    ]);

    Log::shouldReceive('error')->atLeast()->once();

    (new \App\Jobs\SendTransactionNotificationJob($transaction))->handle();
});

test('Job makes the HTTP request correctly', function () {
    $transaction = Transaction::factory()->create();

    Http::fake([
        'https://util.devi.tools/api/v1/notify' => Http::response(['success' => true], 200),
    ]);

    (new \App\Jobs\SendTransactionNotificationJob($transaction))->handle();

    Http::assertSent(function ($request) use ($transaction) {
        return $request->url() === 'https://util.devi.tools/api/v1/notify'
            && $request['user_id'] === $transaction->receiver_id
            && $request['amount'] === $transaction->amount;
    });
});
