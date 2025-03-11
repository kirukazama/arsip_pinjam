<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mpeminjaman;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;


class Monitor extends Component
{
    use WithPagination;

    public $search = '';
    public $showDetail = false;

    public $pinjamTanggal, $pinjamStatus, $keterangan, $pinjamTelp, $catatan, $pinjamTujuan, $kembaliTanggal, $arsipKode, $arsipName, $arsipJenis, $biroName;


    public function render()
    {
        $peminjamans = Mpeminjaman::with(['arsip', 'pegawai', 'biro'])
            ->where('pegawai_id', auth()->user()->pegawai_id)
            ->when($this->search, function ($query) {
                $query->whereHas('arsip', function ($query) {
                    $query->where('arsip_kode', 'like', '%' . $this->search . '%')
                        ->orWhere('arsip_name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(5);

        return view('livewire.monitor', [
            'peminjamans' => $peminjamans, // Langsung kembalikan hasil query pagination ke view
        ]);
    }

    public function detail($id)
    {
        $this->resetDetail();

        $pinjam = Mpeminjaman::with(['arsip', 'biro'])->findOrFail($id);

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
        $this->biroName = $pinjam->biro->biro_name;

        $this->showDetail = true;
    }

    public function resetDetail()
    {
        $this->showDetail = false;
        $this->reset(['pinjamTanggal', 'pinjamStatus', 'keterangan', 'pinjamTelp', 'catatan', 'pinjamTujuan', 'kembaliTanggal', 'arsipKode', 'arsipName', 'arsipJenis', 'biroName']);
    }

    public function verifikasi()
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
}
