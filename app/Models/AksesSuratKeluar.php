<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesSuratKeluar extends Model
{
    use HasFactory;
    protected $fillable = [
        'surat_keluar_id',
        'jabatan_id',
    ];
    public function surat_keluar()
    {
        return $this->belongsTo(SuratKeluar::class);
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
