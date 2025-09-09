<?php

namespace App\Jobs;

use App\Models\Transaction;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Log;

class SendTransactionNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Transaction $transaction) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        rescue(function () {
            $response = Http::post('https://util.devi.tools/api/v1/notify', [
                'user_id' => $this->transaction->receiver_id,
                'amount' => $this->transaction->amount,
            ]);

            if (! $response->successful()) {
                throw new \RuntimeException('Notification service failed: '.$response->status());
            }

        }, function (\Throwable $e) {
            Log::error("Error sending transaction notification for transaction {$this->transaction->id}: ".$e->getMessage());
        });
    }

    public function failed(\Throwable $exception): void
    {
        Log::critical("Permanent failure sending transaction notification for transaction {$this->transaction->id}: ".$exception->getMessage());
    }
}
