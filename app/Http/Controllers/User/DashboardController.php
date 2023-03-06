<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AksesSuratKeluar;
use App\Models\AksesSuratMasuk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('user.dashboard',[
            'surat_masuk' => AksesSuratMasuk::with('surat_masuk','jabatan')->where('jabatan_id',auth()->user()->jabatan_id)->count(),
            'surat_keluar' => AksesSuratKeluar::with('surat_masuk','jabatan')->where('jabatan_id',auth()->user()->jabatan_id)->count(),
        ]);
    }
}
