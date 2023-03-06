<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSuratKeluar extends Model
{
    use HasFactory;
    protected $fillable = [
        'surat_keluar_id',
        'folder',
        'nama_file',
        'extention',
        'uri',
    ];

    public function surat_keluar()
    {
        return $this->belongsTo(SuratKeluar::class);
    }

    public function akses_surat_keluar()
    {
        return $this->hasMany(AksesSuratKeluar::class);
    }
}
