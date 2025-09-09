<?php

namespace App\Livewire\Shared;

use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class AlertManager extends Component
{
    public bool $show = false;

    public string $type = 'success';

    public string $message = '';

    #[On('show-alert')]
    public function showAlert(string $type, string $message): void
    {
        $this->type = $type;
        $this->message = $message;
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
    }

    public function render(): View
    {
        return view('livewire.shared.alert-manager');
    }
}
