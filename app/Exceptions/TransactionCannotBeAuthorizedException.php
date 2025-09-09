<?php

namespace App\Exceptions;

class TransactionCannotBeAuthorizedException extends DomainException
{
    protected $message = 'The transaction was not authorized by the external service.';
}
