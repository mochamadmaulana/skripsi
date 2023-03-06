<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AksesSuratKeluar;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surat_keluar = AksesSuratKeluar::with('surat_keluar','jabatan')->where('jabatan_id',auth()->user()->jabatan_id) ->orderBy('id','DESC')->get();
        return view('user.surat-keluar.index',compact('surat_keluar'));
    }

    public function show($id)
    {
        $surat_keluar = SuratKeluar::with('file_surat_keluar','akses_surat_keluar')->whereId($id)->first();
        return view('user.surat-keluar.detail', compact('surat_keluar'));
    }
}
