<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('kepala-sekolah.dashboard',[
            'surat_masuk' => SuratMasuk::all()->count(),
            'surat_keluar' => SuratKeluar::all()->count(),
        ]);
    }
}
