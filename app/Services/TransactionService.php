<?php

namespace App\Services;

use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Services\Interfaces\TransactionServiceInterface;

class TransactionService extends Service implements TransactionServiceInterface
{
    public function __construct(TransactionRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    // Add service methods here
}
