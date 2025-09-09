<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Collection;

class UserService extends Service implements UserServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
        $this->userRepository = $repository;
    }

    public function getEligibleSenders(): Collection
    {
        return $this->userRepository->getEligibleSenders();
    }

    public function createUser(array $data): User
    {
        return $this->userRepository->createUserWithWallet($data);
    }

    public function deleteUser(User $user): void
    {
        $this->userRepository->deleteUserAndWallet($user);
    }

    public function getUserBalance(int $userId): ?float
    {
        return $this->userRepository->find($userId)?->wallet?->balance;
    }
}
