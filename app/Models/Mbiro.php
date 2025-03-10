<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mbiro extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'biro';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'biro_name'
    ];

    // Tentukan kolom yang tidak dapat diubah (untuk keamanan)
    protected $guarded = ['id'];

    // Jika menggunakan timestamp untuk created_at dan updated_at
    public $timestamps = true;


    public function pegawai()
    {
        return $this->hasMany(Mpegawai::class, 'biro_id');
    }

    public function arsip()
    {
        return $this->hasMany(Marsip::class, 'biro_id');
    }

}
