<?php

namespace App\Listeners;

use App\Events\TransactionCompleted;
use App\Models\Notification;

class StoreTransactionNotification
{
    public function handle(TransactionCompleted $event): void
    {
        $transaction = $event->transaction->load('sender', 'receiver');

        Notification::create([
            'user_id' => $transaction->receiver_id,
            'message' => "{$transaction->sender->name} transferred {$transaction->receiver->name} R$ ".number_format($transaction->amount, 2, ',', '.').'.',
        ]);
    }
}
