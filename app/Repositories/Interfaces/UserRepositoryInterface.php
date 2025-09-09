<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends BaseRepository
{
    public function findWithWallet(int $id): ?User;

    public function updateBalance(User $user, float $newBalance): bool;

    public function getEligibleSenders(): Collection;

    public function createUserWithWallet(array $data): User;

    public function deleteUserAndWallet(User $user): void;
}
