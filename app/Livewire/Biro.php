<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mbiro;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;

class Biro extends Component
{
    use WithPagination;
    public $biroId, $biroName;
    public $search = '';
    public $title = '';
    public $isEditMode = false;
    public $showModal = false;

    protected $rules = [
        'biroName' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.biro', [
            'biros' => Mbiro::when($this->search, function ($query) {
                $query->where('biro_name', 'like', '%' . $this->search . '%');
            })->latest()->paginate(5)
        ]);
    }

    // Reset input fields
    public function resetInput()
    {
        $this->biroId = null;
        $this->biroName = '';
        $this->isEditMode = false;
    }

    // Buka modal untuk tambah data
    public function openModal()
    {
        $this->resetInput();
        $this->showModal = true;
        $this->modal('form-data')->show();
    }

    // Buka modal untuk edit data
    public function edit($id)
    {
        $biro = Mbiro::findOrFail($id);
        $this->biroId = $biro->id;
        $this->biroName = $biro->biro_name;
        $this->isEditMode = true;
        $this->showModal = true;
        $this->modal('form-data')->show();
    }

    // Simpan data (create atau update)
    public function save()
    {
        $this->validate();

        try {
            if ($this->isEditMode) {
                // Update data
                $biro = Mbiro::find($this->biroId);
                $biro->update(['biro_name' => $this->biroName]);
                Toaster::success('Biro berhasil diperbarui.');
            } else {
                // Tambah data baru
                Mbiro::create(['biro_name' => $this->biroName]);
                Toaster::success('Biro berhasil ditambahkan.');
            }

            $this->modal('form-data')->close();
            $this->resetInput();
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id)
    {
        $this->biroId = $id;
        $this->modal('delete')->show();
    }

    // Hapus data
    public function delete()
    {
        try {
            Mbiro::find($this->biroId)->delete();
            Toaster::success('Biro berhasil dihapus.');
            $this->modal('delete')->close();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            Toaster::error('Terjadi kesalahan: ' . $e->getMessage());
            $this->modal('delete')->close();
        }
    }
}
