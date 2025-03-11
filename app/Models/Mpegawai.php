<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mpegawai extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'pegawai';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'pegawai_nip', 'pegawai_name', 'jabatan_name', 'biro_id'
    ];

    // Tentukan kolom yang tidak dapat diubah (untuk keamanan)
    protected $guarded = ['id'];

    // Jika menggunakan timestamp untuk created_at dan updated_at
    public $timestamps = true;


    public function biro()
    {
        return $this->belongsTo(Mbiro::class, 'biro_id');
    }

    public function user(){
        return $this->hasMany(User::class, 'pegawai_id');
    }

    public function peminjaman(){
        return $this->hasMany(Mpeminjaman::class, 'pegawai_id');
    }
}
