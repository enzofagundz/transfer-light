<?php

use App\Livewire\Users\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('should remove the user after deletion', function () {
    $userToDelete = User::factory()->create();
    $userToDelete->wallet()->create(['balance' => 100]);

    $userToKeep = User::factory()->create();
    $userToKeep->wallet()->create(['balance' => 200]);

    Livewire::test(Table::class)
        ->assertSee($userToDelete->name)
        ->call('delete', $userToDelete->id)
        ->assertDontSee($userToDelete->name)
        ->assertSee($userToKeep->name)
        ->assertDispatched('show-alert');
});
