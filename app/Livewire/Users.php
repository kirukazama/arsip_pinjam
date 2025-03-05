<?php

namespace App\Livewire;


use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\User;
use App\Models\Mpegawai;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;
use App\Models\Mrole;

class Users extends Component
{
    use WithPagination;
    public $userId, $userName, $userEmail, $roleId, $pegawaiId;
    public $search = '';
    public $title = '';
    public $isEditMode = false;
    public $showModal = false;

    public $expandedPegawaiIds = [];

    protected $rules = [
        'userName' => 'required|min:3',
        'userEmail' => 'required|email|unique:users,email',
        'roleId' => 'required',
        'pegawaiId' => 'required|exists:pegawai,id',
    ];

    public function toggleExpand($pegawaiId)
    {
        if (in_array($pegawaiId, $this->expandedPegawaiIds)) {
            $this->expandedPegawaiIds = array_diff($this->expandedPegawaiIds, [$pegawaiId]);
        } else {
            $this->expandedPegawaiIds[] = $pegawaiId;
        }
    }

    public function render()
    {
        $pegawais = Mpegawai::when($this->search, function ($query) {
            $query->where('pegawai_name', 'like', '%' . $this->search . '%')
                ->orWhere('pegawai_nip', 'like', '%' . $this->search . '%');
        })->with(['user', 'biro'])
            ->orderBy('pegawai_name')
            ->paginate(10);

        return view('livewire.users', [
            'pegawais' => $pegawais,
            'roles' => Mrole::all(),
        ]);
    }

    // Reset input fields
    public function resetInput()
    {
        $this->userId = null;
        $this->userName = '';
        $this->userEmail = '';
        $this->roleId = '';
        $this->pegawaiId = null;
        $this->isEditMode = false;
    }

    // Buka modal untuk tambah data
    public function openModal($id)
    {
        $this->resetInput();
        $this->pegawaiId = $id;
        $this->showModal = true;
    }

    // Buka modal untuk edit data
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->userName = $user->name;
        $this->userEmail = $user->email;
        $this->pegawaiId = $user->pegawai_id;
        $this->roleId = $user->role_id;
        $this->isEditMode = true;
        $this->showModal = true;
    }

    // Simpan data (create atau update)
    public function save()
    {
        try {
            if ($this->isEditMode) {
                // Update data
                //sdd($this->all());
                $user = User::find($this->userId);
                $user->update([
                    'name' => $this->userName,
                    'email' => $this->userEmail,
                    'role_id' => $this->roleId,
                ]);
                Toaster::success('Akun berhasil diperbarui.');
            } else {
                $this->validate();

                // Tambah data baru

                User::create([
                    'name' => $this->userName,
                    'email' => $this->userEmail,
                    'role_id' => $this->roleId,
                    'pegawai_id' => $this->pegawaiId,
                    'password' => Hash::make('password'),
                ]);
                Toaster::success('Akun berhasil ditambahkan.');
            }

            $this->modal('form-data')->close();
            $this->resetInput();
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id)
    {
        $this->userId = $id;
    }

    // Hapus data
    public function delete()
    {
        try {
            User::find($this->userId)->delete();
            Toaster::success('Akun berhasil dihapus.');
            $this->modal('delete')->close();
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan: ' . $e->getMessage());
            $this->modal('delete')->close();
        }
    }
}
