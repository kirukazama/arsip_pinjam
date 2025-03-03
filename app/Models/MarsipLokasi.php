<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarsipLokasi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'arsip_lokasi';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'lokasi_cabin', 'lokasi_column', 'lokasi_row'
    ];

    // Tentukan kolom yang tidak dapat diubah (untuk keamanan)
    protected $guarded = ['id'];

    // Jika menggunakan timestamp untuk created_at dan updated_at
    public $timestamps = true;
}
