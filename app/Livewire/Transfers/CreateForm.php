<?php

namespace App\Livewire\Transfers;

use App\Livewire\Forms\CreateTransfer;
use App\Livewire\Pages\Dashboard;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('New Transfer')]
class CreateForm extends Component
{
    public CreateTransfer $form;

    public Collection $senders;

    public Collection $receivers;

    public function mount(UserServiceInterface $userService): void
    {
        $this->senders = $userService->getEligibleSenders();
        $this->receivers = $userService->all();
    }

    #[Computed]
    public function senderBalance(): ?float
    {
        if ($this->form->senderId) {
            $userService = resolve(UserServiceInterface::class);
            return $userService->getUserBalance($this->form->senderId);
        }

        return null;
    }

    public function transfer(): void
    {
        try {
            $transaction = $this->form->submit();

            session()->flash('alert', [
                'type' => 'success',
                'message' => "Transaction {$transaction->id} created successfully!",
            ]);

            $this->redirect(Dashboard::class, navigate: true);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            $this->dispatch('show-alert', type: 'error', message: 'Error: '.$ve->validator->errors()->first());
        } catch (\DomainException $e) {
            $this->dispatch('show-alert', type: 'error', message: $e->getMessage());
        } catch (\Throwable $th) {
            report($th);

            $this->dispatch('show-alert', type: 'error', message: 'Something went wrong!'.$th->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.transfers.create-form');
    }
}
