<?php

use App\Livewire\Transfers\CreateForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('shouldn\'t be able to transfer money to yourself', function () {
    $user = User::factory()->create(['type' => \App\Enums\UserType::Common]);
    $user->wallet()->create(['balance' => 100]);

    Livewire::test(CreateForm::class)
        ->set('form.senderId', $user->id)
        ->set('form.receiverId', $user->id)
        ->set('form.amount', 100)
        ->call('transfer')
        ->assertDispatched('show-alert', type: 'error');
});

it('shouldn\'t be able to transfer money from a merchant user', function () {
    $merchantUser = User::factory()->create(['type' => \App\Enums\UserType::Merchant]);
    $commonUser = User::factory()->create(['type' => \App\Enums\UserType::Common]);

    $merchantUser->wallet()->create(['balance' => 100]);
    $commonUser->wallet()->create(['balance' => 100]);

    Livewire::test(CreateForm::class)
        ->set('form.senderId', $merchantUser->id)
        ->set('form.receiverId', $commonUser->id)
        ->set('form.amount', 100)
        ->call('transfer')
        ->assertDispatched('show-alert', type: 'error');
});

it('shouldn\'t be able to transfer a value of 0', function () {
    $sender = User::factory()->create(['type' => \App\Enums\UserType::Common]);
    $receiver = User::factory()->create(['type' => \App\Enums\UserType::Common]);

    $sender->wallet()->create(['balance' => 100]);
    $receiver->wallet()->create(['balance' => 100]);

    Livewire::test(CreateForm::class)
        ->set('form.senderId', $sender->id)
        ->set('form.receiverId', $receiver->id)
        ->set('form.amount', 0)
        ->call('transfer')
        ->assertDispatched('show-alert', type: 'error');
});

it('should be able to transfer money if the data is correct', function () {
    $sender = User::factory()->create(['type' => \App\Enums\UserType::Common]);
    $receiver = User::factory()->create(['type' => \App\Enums\UserType::Merchant]);

    $sender->wallet()->create(['balance' => 100]);
    $receiver->wallet()->create(['balance' => 100]);

    Livewire::test(CreateForm::class)
        ->set('form.senderId', $sender->id)
        ->set('form.receiverId', $receiver->id)
        ->set('form.amount', 100)
        ->call('transfer')
        ->assertRedirect(\App\Livewire\Pages\Dashboard::class);

    $this->assertDatabaseHas('transactions', [
        'sender_id' => $sender->id,
        'receiver_id' => $receiver->id,
        'amount' => 100,
    ]);
});
