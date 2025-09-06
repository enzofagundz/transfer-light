<?php

namespace App\Services;

use App\DTOs\TransferData;
use App\Enums\TransactionStatus;
use App\Events\TransactionCompleted;
use App\Exceptions\ErrorUpdatingBalanceException;
use App\Exceptions\InsufficientFundsException;
use App\Exceptions\MerchantCannotTransferException;
use App\Exceptions\TransactionCannotBeAuthorizedException;
use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\AuthorizeServiceInterface;
use App\Services\Interfaces\TransferServiceInterface;
use DB;

class TransferService implements TransferServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected TransactionRepositoryInterface $transactionRepository,
        protected AuthorizeServiceInterface $authorizeService
    ) {}

    public function transfer(TransferData $data): Transaction
    {
        $sender = $this->userRepository->findWithWallet($data->senderId);
        $receiver = $this->userRepository->findWithWallet($data->receiverId);

        if ($sender->type->isMerchant()) {
            throw new MerchantCannotTransferException;
        }

        if (! $sender->wallet?->canTransfer($data->amount)) {
            throw new InsufficientFundsException;
        }

        if (! $this->authorizeService->authorize()) {
            throw new TransactionCannotBeAuthorizedException;
        }

        $transaction = DB::transaction(function () use ($data, $sender, $receiver) {
            $newSenderBalance = $sender->wallet->balance - $data->amount;
            $newReceiverBalance = $receiver->wallet->balance + $data->amount;

            $senderReceived = $this->userRepository->updateBalance($sender, $newSenderBalance);
            $receiverReceived = $this->userRepository->updateBalance($receiver, $newReceiverBalance);

            if (! $senderReceived || ! $receiverReceived) {
                throw new ErrorUpdatingBalanceException;
            }

            return $this->transactionRepository->create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $data->amount,
                'status' => TransactionStatus::Completed->value,
            ]);
        });

        TransactionCompleted::dispatch($transaction);

        return $transaction;
    }
}
