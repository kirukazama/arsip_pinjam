<?php

namespace App\Livewire;
use App\Models\Mrole;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

use Livewire\Component;

class Role extends Component
{
    use WithPagination;
    public $roleId, $roleName;
    public $search = '';
    public $title = '';
    public $isEditMode = false;
    public $showModal = false;

    protected $rules = [
        'roleName' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.role', [
            'roles' => Mrole::when($this->search, function ($query) {
                $query->where('role_name', 'like', '%' . $this->search . '%');
            })->latest()->paginate(5)
        ]);
    }

    // Reset input fields
    public function resetInput()
    {
        $this->roleId = null;
        $this->roleName = '';
        $this->isEditMode = false;
    }

    // Buka modal untuk tambah data
    public function openModal()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    // Buka modal untuk edit data
    public function edit($id)
    {
        $role = Mrole::findOrFail($id);
        $this->roleId = $role->id;
        $this->roleName = $role->role_name;
        $this->isEditMode = true;
        $this->showModal = true;
    }

    // Simpan data (create atau update)
    public function save()
    {
        $this->validate();
        
        try {
            if ($this->isEditMode) {
                // Update data
                $role = Mrole::find($this->roleId);
                $role->update(['role_name' => $this->roleName]);
                Toaster::success('Role berhasil diperbarui.');
            } else {
                // Tambah data baru
                Mrole::create(['role_name' => $this->roleName]);
                Toaster::success('Role berhasil ditambahkan.');
            }

            $this->modal('form-data')->close();
            $this->resetInput();

        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Hapus data
    public function delete($id)
    {
        try {
            Mrole::find($id)->delete();
            Toaster::success('Role berhasil dihapus.');
            $this->modal('delete')->close();
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan: ' . $e->getMessage());
            $this->modal('delete')->close();
        }
    }
}
