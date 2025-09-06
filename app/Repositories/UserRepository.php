<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * @extends Repository<User>
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findWithWallet(int $id): ?User
    {
        return $this->model->with('wallet')->find($id);
    }

    public function updateBalance(User $user, float $newBalance): bool
    {
        return $user->wallet()->update(['balance' => $newBalance]) > 0;
    }
}
