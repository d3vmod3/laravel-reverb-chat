<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
// use App\Livewire\Messages\Messages;
use App\Livewire\Messages\Conversations;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    // Route::get('messages', Messages::class)->name('messages.messages');
    Route::get('conversations', Conversations::class)->name('messages.conversations');
    Route::get('conversations/{id}', Conversations::class)->name('messages.conversation');
});


require __DIR__.'/auth.php';
