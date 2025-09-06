<?php

namespace App\Listeners;

use App\Events\TransactionCompleted;
use App\Jobs\SendTransactionNotificationJob;

class SendTransactioNotification
{
    public function handle(TransactionCompleted $event): void
    {
        SendTransactionNotificationJob::dispatch($event->transaction);
    }
}
