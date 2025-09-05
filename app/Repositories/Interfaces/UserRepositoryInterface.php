<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface extends BaseRepository
{
    public function findWithWallet(int $id): ?User;

    public function updateBalance(User $user, float $newBalance): bool;
}
