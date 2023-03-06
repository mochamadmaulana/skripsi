<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function akses_surat_masuk()
    {
        return $this->hasMany(AksesSuratMasuk::class);
    }

    public function akses_surat_keluar()
    {
        return $this->hasMany(AksesSuratKeluar::class);
    }
}
