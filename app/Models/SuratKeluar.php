<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomor_agenda',
        'nomor_surat',
        'nama_surat',
        'ditujukan_kepada',
        'tanggal_surat',
        'tanggal_keluar',
        'perihal',
        'status_approve',
    ];

    public function file_surat_keluar()
    {
        return $this->hasMany(FileSuratKeluar::class);

    }
    public function disposisi_surat_keluar()
    {
        return $this->hasMany(DisposisiSuratKeluar::class);
    }
}
