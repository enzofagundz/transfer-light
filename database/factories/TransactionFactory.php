<?php

namespace Database\Factories;

use App\Enums\TransactionStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender_id' => User::factory(['type' => UserType::Common]),
            'receiver_id' => User::factory(['type' => UserType::Merchant]),
            'amount' => $this->faker->randomFloat(2, 0, 10000),
            'status' => $this->faker->randomElement([TransactionStatus::Pending, TransactionStatus::Completed, TransactionStatus::Failed]),
        ];
    }
}
