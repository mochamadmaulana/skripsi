<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomor_agenda',
        'nomor_surat',
        'nama_surat',
        'nama_pengirim',
        'tanggal_surat',
        'tanggal_diterima',
        'perihal',
    ];

    public function file_surat_masuk()
    {
        return $this->hasMany(FileSuratMasuk::class);
    }

    public function disposisi_surat_masuk()
    {
        return $this->hasMany(DisposisiSuratMasuk::class);
    }
}
