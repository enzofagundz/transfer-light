<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\PostUser;
use App\Livewire\Pages\Dashboard;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Add New User')]
class CreateForm extends Component
{
    public PostUser $form;

    public function save(UserServiceInterface $userService): void
    {
        try {
            $user = $this->form->store($userService);

            session()->flash('alert', [
                'type' => 'success',
                'message' => "User {$user->name} created successfully!",
            ]);

            $this->redirect(Dashboard::class, navigate: true);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            $this->dispatch('show-alert', type: 'error', message: 'Error: '.$ve->validator->errors()->first());
        } catch (\Throwable $th) {
            report($th);

            $this->dispatch('show-alert', type: 'error', message: 'Something went wrong!');
        }
    }

    public function render(): View
    {
        return view('livewire.users.create-form');
    }
}
