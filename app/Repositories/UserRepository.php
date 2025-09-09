<?php

namespace App\Repositories;

use App\Enums\UserType;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use DB;
use Hash;
use Illuminate\Support\Collection;

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

    public function getEligibleSenders(): Collection
    {
        return $this->model->where('type', '!=', UserType::Merchant)->get();
    }

    public function createUserWithWallet(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = $this->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'cpf_cnpj' => $data['cpf_cnpj'],
                'type' => $data['type'],
            ]);

            $user->wallet()->create([
                'balance' => $data['balance'],
            ]);

            return $user;
        });
    }

    public function deleteUserAndWallet(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->wallet()->delete();
            $user->delete();
        });
    }
}
