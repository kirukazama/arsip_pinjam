<?php

namespace App\Livewire;
use App\Models\Mpegawai;
use App\Models\Mbiro;
use Livewire\WithPagination;

use Livewire\Component;

class Pegawai extends Component
{
    use WithPagination;
    public $pegawaiId, $pegawaiName, $pegawaiNip, $jabatanName, $biroId;
    public $search = '';
    public $title = '';
    public $isEditMode = false;
    public $showModal = false;
    //public $pegawais;
    public $biros;

    protected $rules = [
        'pegawaiName' => 'required|string',
        'pegawaiNip' => 'required|string|size:18',
        'jabatanName' => 'required|string',
        'biroId' => 'required',
    ];

    public function updatingSearch()
    {
        $this->resetPage(); // Reset ke halaman 1 saat pencarian berubah
    }
    

    public function render()
    {
        $pegawais = Mpegawai::with('biro')
            ->when($this->search, function ($query) {
                $query->where('pegawai_name', 'like', '%' . $this->search . '%')
                      ->orWhere('pegawai_nip', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(5);

        $this->biros = Mbiro::all();

        return view('livewire.pegawai', [
            'pegawais' => $pegawais, // Langsung kirim ke view
            'biros' => $this->biros,
        ]);
    }

    // Reset input fields
    public function resetInput()
    {
        $this->pegawaiId = null;
        $this->pegawaiNip = '';
        $this->pegawaiName = '';
        $this->jabatanName = '';
        $this->biroId = '';
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
        $pegawai = Mpegawai::findOrFail($id);
        $this->pegawaiId = $pegawai->id;
        $this->pegawaiNip = $pegawai->pegawai_nip;
        $this->pegawaiName = $pegawai->pegawai_name;
        $this->jabatanName = $pegawai->jabatan_name;
        $this->biroId = $pegawai->biro_id;
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
                $pegawai = Mpegawai::find($this->pegawaiId);
                $pegawai->update([
                    'pegawai_nip' => $this->pegawaiNip,
                    'pegawai_name' => $this->pegawaiName,
                    'jabatan_name' => $this->jabatanName,
                    'biro_id' => $this->biroId,
                ]);
                session()->flash('message', 'Pegawai berhasil diperbarui.');
            } else {
                // Tambah data baru
                Mpegawai::create([
                    'pegawai_nip' => $this->pegawaiNip,
                    'pegawai_name' => $this->pegawaiName,
                    'jabatan_name' => $this->jabatanName,
                    'biro_id' => $this->biroId,]);
                session()->flash('message', 'Pegawai berhasil ditambahkan.');
            }

            $this->modal('form-data')->close();
            //$this->modal('success')->show();
            $this->resetInput();

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Hapus data
    public function delete($id)
    {
        try {
            Mpegawai::find($id)->delete();
            session()->flash('message', 'Pegawai berhasil dihapus.');
            $this->modal('delete')->close();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            $this->modal('delete')->close();
        }
    }
}
