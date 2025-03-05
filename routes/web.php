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

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Volt::route('biro', 'biro')->name('biro');
    Volt::route('role', 'role')->name('role');
    Volt::route('pegawai', 'pegawai')->name('pegawai');
    Volt::route('users', 'users')->name('users');
    Volt::route('inbox', 'inbox')->name('inbox');
    Volt::route('arsiplokasi', 'arsiplokasi')->name('arsiplokasi');
});

require __DIR__.'/auth.php';
