<?php

namespace App\Livewire\Pages;

use Illuminate\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public function mount(): void
    {
        if (session()->has('alert')) {
            $alert = session('alert');
            $this->dispatch('show-alert', type: $alert['type'], message: $alert['message']);
        }
    }

    public function render(): View
    {
        return view('livewire.pages.dashboard');
    }
}
