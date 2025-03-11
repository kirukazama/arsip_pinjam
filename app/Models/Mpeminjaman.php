<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mpeminjaman extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'peminjaman';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'pinjam_tanggal', 'pinjam_status', 'keterangan', 'pinjam_telp', 'catatan', 'pinjam_tujuan', 'kembali_tanggal', 'arsip_id', 'pegawai_id', 'biro_id'
    ];

    // Tentukan kolom yang tidak dapat diubah (untuk keamanan)
    protected $guarded = ['id'];

    // Jika menggunakan timestamp untuk created_at dan updated_at
    public $timestamps = true;

    public function biro()
    {
        return $this->belongsTo(Mbiro::class, 'biro_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Mpegawai::class, 'pegawai_id');
    }

    public function arsip()
    {
        return $this->belongsTo(Marsip::class, 'arsip_id');
    }
}
