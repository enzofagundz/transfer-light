<?php

namespace App\DTOs;

class TransferData
{
    public function __construct(
        public readonly int $senderId,
        public readonly int $receiverId,
        public readonly float $amount
    ) {}
}
