<?php

namespace App\Livewire\Forms;

use App\Enums\UserType;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PostUser extends Form
{
    #[Validate(['required', 'min:3', 'max:255'])]
    public string $name = '';

    #[Validate(['required', 'email', 'min:3', 'max:255', 'unique:users,email'])]
    public string $email = '';

    #[Validate(['required', 'min:3', 'max:255'])]
    public string $password = '';

    #[Validate(['required', 'min:3', 'max:255', 'confirmed:password'])]
    public string $password_confirmation = '';

    #[Validate(['required', 'min:3', 'max:255', 'unique:users,cpf_cnpj'])]
    public string $cpf_cnpj = '';

    #[Validate(['required'])]
    public UserType $type = UserType::Common;

    #[Validate(['required', 'numeric', 'min:0'])]
    public float $balance = 0;

    public function store(UserServiceInterface $userService): User
    {
        $this->validate();

        $user = $userService->createUser($this->all());

        $this->reset();

        return $user;
    }
}
