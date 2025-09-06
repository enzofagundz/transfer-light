<?php

namespace App\Enums;

enum UserType: int
{
    case Common = 1;
    case Merchant = 2;

    public function isMerchant(): bool
    {
        return $this === self::Merchant;
    }
}
