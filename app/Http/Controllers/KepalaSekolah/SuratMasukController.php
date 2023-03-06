<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;

class SuratMasukController extends Controller
{
    public function index()
    {
        $surat_masuk = SuratMasuk::with('file_surat_masuk','akses_surat_masuk')->orderBy('id','DESC')->get();
        return view('kepala-sekolah.surat-masuk.index',compact('surat_masuk'));
    }

    public function show($id)
    {
        $surat_masuk = SuratMasuk::with('file_surat_masuk','akses_surat_masuk')->whereId($id)->first();
        return view('kepala-sekolah.surat-masuk.detail', compact('surat_masuk'));
    }

}
