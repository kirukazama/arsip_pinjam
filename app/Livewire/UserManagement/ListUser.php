<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ListUser extends Component
{
    public array $users = [];
    public string $username = '';
    public string $nama_pegawai = '';
    public string $email = '';
    public string $role = '';
    public string $search = ''; // Tambahkan wire:model ke frontend
    public int $perPage = 5;


    public function mount()
    {
        $this->users = [
            ['username' => 'jdoe', 'nama_pegawai' => 'John Doe', 'email' => 'jdoe@example.com', 'role' => 'Admin'],
            ['username' => 'asmith', 'nama_pegawai' => 'Alice Smith', 'email' => 'asmith@example.com', 'role' => 'User'],
            ['username' => 'bjackson', 'nama_pegawai' => 'Bob Jackson', 'email' => 'bjackson@example.com', 'role' => 'Approver'],
            ['username' => 'charris', 'nama_pegawai' => 'Charlie Harris', 'email' => 'charris@example.com', 'role' => 'User'],
            ['username' => 'dmiller', 'nama_pegawai' => 'Daniel Miller', 'email' => 'dmiller@example.com', 'role' => 'Admin'],
            ['username' => 'emartinez', 'nama_pegawai' => 'Emma Martinez', 'email' => 'emartinez@example.com', 'role' => 'User'],
            ['username' => 'fgarcia', 'nama_pegawai' => 'Francis Garcia', 'email' => 'fgarcia@example.com', 'role' => 'User'],
        ];
    }

    public function getPaginatedUsersProperty()
    {
        $filteredUsers = collect($this->users)->filter(function ($user) {
            return stripos($user['username'], $this->search) !== false ||
                   stripos($user['nama_pegawai'], $this->search) !== false ||
                   stripos($user['email'], $this->search) !== false ||
                   stripos($user['role'], $this->search) !== false;
        })->values()->all(); // Perbaiki indeks setelah filter

        $page = request()->query('page', 1);
        $items = array_slice($filteredUsers, ($page - 1) * $this->perPage, $this->perPage);

        return new LengthAwarePaginator($items, count($filteredUsers), $this->perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
    }

    public function addUser($userData)
{
    array_unshift($this->users, [
        'username' => $userData['username'],
        'nama_pegawai' => $userData['nama_pegawai'],
        'email' => $userData['email'],
        'role' => $userData['role']
    ]);
}

    public function render()
    {
        return view('livewire.user-management.list-user', [
            'paginatedUsers' => $this->getPaginatedUsersProperty(),
        ]);
    }
}
