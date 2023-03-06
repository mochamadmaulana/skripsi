<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AksesSuratMasuk;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index()
    {
        $surat_masuk = AksesSuratMasuk::with('surat_masuk','jabatan')->where('jabatan_id',auth()->user()->jabatan_id) ->orderBy('id','DESC')->get();
        return view('user.surat-masuk.index',compact('surat_masuk'));
    }

    public function show($id)
    {
        $surat_masuk = SuratMasuk::with('file_surat_masuk','akses_surat_masuk')->whereId($id)->first();
        return view('user.surat-masuk.detail', compact('surat_masuk'));
    }
}
