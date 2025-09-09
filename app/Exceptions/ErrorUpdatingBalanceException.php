<?php

namespace App\Exceptions;

class ErrorUpdatingBalanceException extends DomainException
{
    protected $message = 'An error occurred while updating balances. The transaction has been rolled back.';
}
