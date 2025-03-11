<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mpeminjaman;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Inbox extends Component
{
    use WithPagination;

    public $search = '';
    public $showDetail = false;

    public $peminjamanId, $pinjamTanggal, $pinjamStatus, $keterangan, $pinjamTelp, $catatan, $pinjamTujuan, $kembaliTanggal, $arsipKode, $arsipName, $arsipJenis, $biroName, $pegawaiName, $pegawaiEmail;

    public function render()
    {
        $peminjamans = Mpeminjaman::with(['arsip', 'pegawai', 'biro'])
            ->where('biro_id', auth()->user()->pegawai->biro_id)
            ->when($this->search, function ($query) {
                $query->whereHas('arsip', function ($query) {
                    $query->where('arsip_kode', 'like', '%' . $this->search . '%')
                        ->orWhere('arsip_name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(5);

        return view('livewire.inbox', [
            'peminjamans' => $peminjamans, // Langsung kembalikan hasil query pagination ke view
        ]);
    }

    public function detail($id)
    {
        $this->resetDetail();

        $pinjam = Mpeminjaman::with(['arsip', 'biro', 'pegawai.user'])->findOrFail($id);

        $this->peminjamanId = $id;
        $this->pinjamTanggal = $pinjam->pinjam_tanggal;
        $this->kembaliTanggal = $pinjam->kembali_tanggal;
        $this->pinjamStatus = $pinjam->pinjam_status;
        $this->pinjamTelp = $pinjam->pinjam_telp;
        $this->keterangan = $pinjam->keterangan;
        $this->catatan = $pinjam->catatan;
        $this->pinjamTujuan = $pinjam->pinjam_tujuan;
        $this->arsipKode = $pinjam->arsip->arsip_kode;
        $this->arsipName = $pinjam->arsip->arsip_name;
        $this->arsipJenis = $pinjam->arsip->arsip_jenis;
        $this->biroName = $pinjam->pegawai->biro->biro_name;
        $this->pegawaiName = $pinjam->pegawai->pegawai_name;
        $this->pegawaiEmail = $pinjam->pegawai?->user->pluck('email')->first();
        $this->showDetail = true;
    }

    public function resetDetail()
    {
        $this->showDetail = false;
        $this->reset([
            'pinjamTanggal', 'pinjamStatus', 'keterangan', 'pinjamTelp',
            'catatan', 'pinjamTujuan', 'kembaliTanggal', 'arsipKode', 'arsipName',
            'arsipJenis', 'biroName', 'pegawaiName', 'pegawaiEmail', 'peminjamanId'
        ]);
    }

    public function verifikasi()
    {
        try {
            $this->validate([
                'pinjamStatus' => 'required|string',
                'catatan' => 'required|string',
            ]);

            // Ambil biro_id dari user yang login
            $biroId = auth()->user()->pegawai->biro_id;
            $pegawaiId = auth()->user()->pegawai_id;

            $peminjaman = Mpeminjaman::find($this->peminjamanId);
            $peminjaman->update([
                'pinjam_status' => $this->pinjamStatus,
                'catatan' => $this->catatan,
            ]);

            $this->modal('pinjam-modal')->close();
            Toaster::success('Verifikasi berhasail.');
            $this->resetDetail();
        } catch (\Exception $e) {
            $this->modal('pinjam-modal')->close();
            Toaster::error('Terjadi kesalahan: ' . $e->getMessage());
            $this->resetDetail();
        }
    }
}
