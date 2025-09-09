<?php

namespace App\Exceptions;

class InsufficientFundsException extends DomainException
{
    protected $message = 'The sender does not have sufficient funds for this transfer.';
}
