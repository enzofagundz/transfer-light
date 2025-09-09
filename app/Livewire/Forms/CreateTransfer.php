<?php

namespace App\Livewire\Forms;

use App\DTOs\TransferData;
use App\Models\Transaction;
use App\Rules\NotMerchant;
use App\Services\Interfaces\TransferServiceInterface;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateTransfer extends Form
{
    private TransferServiceInterface $transferService;

    #[Validate(['required', 'numeric', 'min:0.01'])]
    public ?float $amount = null;

    #[Validate(['required', 'numeric', 'exists:users,id', new NotMerchant])]
    public ?int $senderId = null;

    #[Validate(['required', 'numeric', 'exists:users,id', 'different:senderId'])]
    public ?int $receiverId = null;

    public function boot(TransferServiceInterface $transferService): void
    {
        $this->transferService = $transferService;
    }

    public function submit(): Transaction
    {
        $this->validate();

        return $this->transferService->transfer(new TransferData(
            senderId: $this->senderId,
            receiverId: $this->receiverId,
            amount: $this->amount
        ));
    }
}
