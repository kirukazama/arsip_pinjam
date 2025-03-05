<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MarsipLokasi;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class ArsipLokasi extends Component
{
    use WithPagination;
    public $lokasiId, $lokasiCabin, $lokasiColumn, $lokasiRow;
    public $search = '';
    public $title = '';
    public $isEditMode = false;
    public $showModal = false;

    protected $rules = [
        'lokasiCabin' => 'required|string',
        'lokasiColumn' => 'required|string',
        'lokasiRow' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.arsip-lokasi', [
            'lArsips' => MarsipLokasi::when($this->search, function ($query) {
                $query->where('lokasi_cabin', 'like', '%' . $this->search . '%')
                ->orWhere('lokasi_column', 'like', '%' . $this->search . '%')
                ->orWhere('lokasi_row', 'like', '%' . $this->search . '%');
            })->latest()->paginate(5)
        ]);
    }

    // Reset input fields
    public function resetInput()
    {
        $this->lokasiId = null;
        $this->lokasiCabin = '';
        $this->lokasiColumn = '';
        $this->lokasiRow = '';
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
        $lArsip = MarsipLokasi::findOrFail($id);
        $this->lokasiId = $lArsip->id;
        $this->lokasiCabin = $lArsip->lokasi_cabin;
        $this->lokasiColumn = $lArsip->lokasi_column;
        $this->lokasiRow = $lArsip->lokasi_row;
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
                $lArsip = MarsipLokasi::find($this->lokasiId);
                $lArsip->update([
                    'lokasi_cabin' => $this->lokasiCabin,
                    'lokasi_column' => $this->lokasiColumn,
                    'lokasi_row' => $this->lokasiRow,
                ]);
                Toaster::success('Lokasi Arsip berhasil diperbarui.');
            } else {
                // Tambah data baru
                MarsipLokasi::create([
                    'lokasi_cabin' => $this->lokasiCabin,
                    'lokasi_column' => $this->lokasiColumn,
                    'lokasi_row' => $this->lokasiRow,]);
                Toaster::success('Lokasi Arsip berhasil ditambahkan.');
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
            MarsipLokasi::find($id)->delete();
            Toaster::success('Lokasi Arsip berhasil dihapus.');
            $this->modal('delete')->close();
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan: ' . $e->getMessage());
            $this->modal('delete')->close();
        }
    }
}
