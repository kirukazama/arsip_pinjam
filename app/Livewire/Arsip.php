<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Marsip;
use App\Models\Mbiro;
use App\Models\MarsipLokasi;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Arsip extends Component
{
    use WithPagination;

    public $arsipId, $arsipKode, $arsipName, $arsipMasuk, $arsipAkhir, $isActive, $lokasiId, $biroId, $arsipJenis, $jumlah, $arsipKeterangan;
    public $search = '';
    public $isEditMode = false;
    public $showModal = false;
    public $jenisArr = ['fisik', 'digital'];

    protected $rules = [
        'arsipKode' => 'required|string',
        'arsipName' => 'required|string',
        'arsipMasuk' => 'required|date',
        'arsipAkhir' => 'required|date',
        'isActive' => 'required|boolean',
        'lokasiId' => 'required|integer',
        'biroId' => 'required|integer',
        'arsipJenis' => 'required|string', 
        'jumlah' => 'required|integer',
        'arsipKeterangan' => 'required|string'
    ];

    public function render()
    {
        return view('livewire.arsip', [
            'arsips' => Marsip::with(['lokasi', 'biro'])
            ->when($this->search, function ($query) {
                $query->where('arsip_kode', 'like', '%' . $this->search . '%')
                    ->orWhere('arsip_name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(5),
            'biros' => Mbiro::all(),
            'lokasis' => MarsipLokasi::all(),
            'jenisArr' => $this->jenisArr,
        ]);
    }

    // Reset input fields
    public function resetInput()
    {
        $this->arsipId = null;
        $this->arsipKode = '';
        $this->arsipName = '';
        $this->arsipMasuk = '';
        $this->arsipAkhir = '';
        $this->isActive = false;
        $this->lokasiId = '';
        $this->biroId = '';
        $this->isEditMode = false;
        $this->arsipJenis = '';
        $this->jumlah = '';
        $this->arsipKeterangan ='';
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
        $this->resetInput();
        $arsip = Marsip::findOrFail($id);
        $this->arsipId = $arsip->id;
        $this->arsipKode = $arsip->arsip_kode;
        $this->arsipName = $arsip->arsip_name;
        $this->arsipMasuk = $arsip->arsip_masuk;
        $this->arsipAkhir = $arsip->arsip_akhir;
        $this->isActive = $arsip->is_active;
        $this->arsipJenis = $arsip->arsip_jenis;
        $this->jumlah = $arsip->jumlah; 
        $this->arsipKeterangan = $arsip->arsip_keterangan;
        $this->lokasiId = $arsip->lokasi_id;
        $this->biroId = $arsip->biro_id;
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
                $arsip = Marsip::find($this->arsipId);
                $arsip->update([
                    'arsip_kode' => $this->arsipKode,
                    'arsip_name' => $this->arsipName,
                    'arsip_masuk' => $this->arsipMasuk,
                    'arsip_akhir' => $this->arsipAkhir,
                    'is_active' => $this->isActive,
                    'arsip_jenis' => $this->arsipJenis,
                    'jumlah' => $this->jumlah, 
                    'arsip_keterangan' => $this->arsipKeterangan,
                    'lokasi_id' => $this->lokasiId,
                    'biro_id' => $this->biroId,
                ]);
                Toaster::success('Arsip berhasil diperbarui.');
            } else {
                // Tambah data baru
                Marsip::create([
                    'arsip_kode' => $this->arsipKode,
                    'arsip_name' => $this->arsipName,
                    'arsip_masuk' => $this->arsipMasuk,
                    'arsip_akhir' => $this->arsipAkhir,
                    'is_active' => $this->isActive,
                    'arsip_jenis' => $this->arsipJenis,
                    'jumlah' => $this->jumlah, 
                    'arsip_keterangan' => $this->arsipKeterangan,
                    'lokasi_id' => $this->lokasiId,
                    'biro_id' => $this->biroId,
                ]);
                Toaster::success('Arsip berhasil ditambahkan.');
            }

            $this->modal('form-data')->close();
            $this->resetInput();

        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id)
    {
        $this->arsipId = $id;
        $this->modal('delete')->show();
    }

    // Hapus data
    public function delete()
    {
        try {
            Marsip::find($this->arsipId)->delete();
            Toaster::success('Arsip berhasil dihapus.');
            $this->modal('delete')->close();
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan: ' . $e->getMessage());
            $this->modal('delete')->close();
        }
    }
}