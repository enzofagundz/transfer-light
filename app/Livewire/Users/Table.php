<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Users')]
class Table extends Component
{
    public Collection $users;

    public function mount(UserServiceInterface $userService): void
    {
        $this->users = $userService->all();
    }

    public function delete(User $user, UserServiceInterface $userService): void
    {
        $userService->deleteUser($user);

        $this->users = $this->users->reject(fn ($u) => $u->id === $user->id);

        $this->dispatch('show-alert', type: 'success', message: 'User deleted successfully!');
    }

    public function render(): View
    {
        return view('livewire.users.table');
    }
}
