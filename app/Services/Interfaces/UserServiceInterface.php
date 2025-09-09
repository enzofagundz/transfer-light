<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserServiceInterface extends BaseService
{
    public function getEligibleSenders(): Collection;

    public function createUser(array $data): User;

    public function deleteUser(User $user): void;

    public function getUserBalance(int $userId): ?float;
}
