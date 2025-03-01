<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mrole extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'role';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'role_name'
    ];

    // Tentukan kolom yang tidak dapat diubah (untuk keamanan)
    protected $guarded = ['id'];

    // Jika menggunakan timestamp untuk created_at dan updated_at
    public $timestamps = true;

}
