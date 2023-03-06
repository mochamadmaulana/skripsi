<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesSuratMasuk extends Model
{
    use HasFactory;
    protected $fillable = [
        'surat_masuk_id',
        'jabatan_id',
    ];
    public function surat_masuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
