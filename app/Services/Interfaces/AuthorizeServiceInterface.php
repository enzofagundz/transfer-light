<?php

namespace App\Services\Interfaces;

interface AuthorizeServiceInterface
{
    public function checkAuthorization(): bool;
}
