<?php

use App\Livewire\UserManagement\ListUser;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('user-management', ListUser::class)->name('user-management');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Volt::route('biro', 'biro')->name('biro');
    Volt::route('role', 'role')->name('role');
    Volt::route('pegawai', 'pegawai')->name('pegawai');
    Volt::route('user', 'user')->name('user');
});

require __DIR__.'/auth.php';
