<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSuratMasuk extends Model
{
    use HasFactory;
    protected $fillable = [
        'surat_masuk_id',
        'folder',
        'nama_file',
        'extention',
        'uri',
    ];

    public function surat_masuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    public function akses_surat_masuk()
    {
        return $this->hasMany(AksesSuratMasuk::class);
    }
}
