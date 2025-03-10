<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marsip extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'arsip';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'arsip_kode', 'arsip_name', 'arsip_masuk', 'arsip_akhir', 'is_active', 'lokasi_id', 'biro_id', 'arsip_jenis', 'jumlah', 'arsip_keterangan'
    ];

    // Tentukan kolom yang tidak dapat diubah (untuk keamanan)
    protected $guarded = ['id'];

    // Jika menggunakan timestamp untuk created_at dan updated_at
    public $timestamps = true;

    public function biro()
    {
        return $this->belongsTo(Mbiro::class, 'biro_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(MarsipLokasi::class, 'lokasi_id');
    }
}
