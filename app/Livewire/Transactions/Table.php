<?php

namespace App\Livewire\Transactions;

use App\Services\Interfaces\TransactionServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Table extends Component
{
    public Collection $transactions;

    public function mount(TransactionServiceInterface $transactionService): void
    {
        $this->transactions = $transactionService->all();
    }

    public function render(): View
    {
        return view('livewire.transactions.table');
    }
}
