<?php

namespace App\Exceptions;

class MerchantCannotTransferException extends DomainException
{
    protected $message = 'Merchants are not allowed to send money, only receive.';
}
