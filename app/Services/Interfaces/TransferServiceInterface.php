<?php

namespace App\Services\Interfaces;

use App\DTOs\TransferData;
use App\Models\Transaction;

interface TransferServiceInterface
{
    public function transfer(TransferData $data): Transaction;
}
