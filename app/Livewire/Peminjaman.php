<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Marsip;
use App\Models\Mpeminjaman;
use Masmerise\Toaster\Toaster;

class Peminjaman extends Component
{
    use WithPagination;

    public $search = '';

    // Properti untuk modal peminjaman
    public $pinjamTanggal, $pinjamTelp, $keterangan, $pinjamTujuan, $kembaliTanggal;
    public $showPinjamModal = false;
    public $selectedArsipId;

    public function render()
    {
        // Query data arsip dengan pagination
        $arsips = Marsip::with(['lokasi', 'biro'])
            ->when($this->search, function ($query) {
                $query->where('arsip_kode', 'like', '%' . $this->search . '%')
                    ->orWhere('arsip_name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(5);

        return view('livewire.peminjaman', [
            'arsips' => $arsips, // Langsung kembalikan hasil query pagination ke view
        ]);
    }

    // Buka modal peminjaman
    public function openPinjamModal($arsipId)
    {
        $this->resetPinjamModal();
        $this->selectedArsipId = $arsipId;
        $this->showPinjamModal = true;
    }

    // Proses peminjaman
    public function pinjam()
    {
        try {
            $this->validate([
                'pinjamTanggal' => 'required|date|after_or_equal:today',
                'pinjamTelp' => 'required|string',
                'keterangan' => 'string',
                'pinjamTujuan' => 'required|string',
                'kembaliTanggal' => 'required|date|after:pinjamTanggal',
            ]);

            // Ambil biro_id dari user yang login
            $biroId = auth()->user()->pegawai->biro_id;
            $pegawaiId = auth()->user()->pegawai_id;

            $peminjaman = Mpeminjaman::create([
                'pinjam_tanggal' => $this->pinjamTanggal,
                'pinjam_status' => 'pengajuan',
                'catatan' => '',
                'pinjam_telp' => $this->pinjamTelp,
                'keterangan' => $this->keterangan,
                'pinjam_tujuan' => $this->pinjamTujuan,
                'kembali_tanggal' => $this->kembaliTanggal,
                'arsip_id' => $this->selectedArsipId,
                'pegawai_id' => $pegawaiId, // Ambil pegawai_id user yang login
                'biro_id' => $biroId, // Ambil biro_id dari user yang login
            ]);

            Toaster::success('Arsip berhasil dipinjam.');
            $this->resetPinjamModal();
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Reset modal peminjaman
    public function resetPinjamModal()
    {
        $this->showPinjamModal = false;
        $this->reset(['pinjamTanggal', 'pinjamTelp', 'pinjamTujuan', 'kembaliTanggal', 'keterangan']);
    }
}
