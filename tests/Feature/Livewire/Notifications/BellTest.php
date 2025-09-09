<?php

use App\Livewire\Notifications\Bell;
use App\Models\User;
use Livewire\Livewire;

it('should be able to mark all notifications as read', function () {
    $commonUser = User::factory()->create(['type' => \App\Enums\UserType::Common]);
    $merchantUser = User::factory()->create(['type' => \App\Enums\UserType::Merchant]);

    $commonUser->wallet()->create(['balance' => 100]);
    $merchantUser->wallet()->create(['balance' => 100]);

    $transferService = app()->make(\App\Services\Interfaces\TransferServiceInterface::class);

    $transferService->transfer(new \App\DTOs\TransferData(
        senderId: $commonUser->id,
        receiverId: $merchantUser->id,
        amount: 100
    ));

    Livewire::test(Bell::class)
        ->call('markAllAsRead')
        ->assertSet('unreadNotificationsCount', 0);
});
