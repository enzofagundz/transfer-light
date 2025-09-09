<?php

use Illuminate\Support\Facades\Route;

Route::get('/', action: \App\Livewire\Pages\Dashboard::class)->name('dashboard');
Route::get('/users/create', action: \App\Livewire\Users\CreateForm::class)->name('users.create');
Route::get('/transfers/create', action: \App\Livewire\Transfers\CreateForm::class)->name('transfers.create');
