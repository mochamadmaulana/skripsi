<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surat_keluar = SuratKeluar::with('file_surat_keluar','akses_surat_keluar')->orderBy('id','DESC')->get();
        return view('kepala-sekolah.surat-keluar.index',compact('surat_keluar'));
    }

    public function setuju($id)
    {
        $surat_keluar = SuratKeluar::whereId($id)->first();
        $surat_keluar->update(['status_approve' => 'Disetujui']);
        return back()->with('success', 'Berhasil menyetujui surat keluar dengan nomor agenda '.$surat_keluar->nomor_agenda);
    }

    public function tolak($id)
    {
        $surat_keluar = SuratKeluar::whereId($id)->first();
        $surat_keluar->update(['status_approve' => 'Ditolak']);
        return back()->with('success', 'Berhasil menolak surat keluar dengan nomor agenda '.$surat_keluar->nomor_agenda);
    }

    public function show($id)
    {
        $surat_keluar = SuratKeluar::with('file_surat_keluar','akses_surat_keluar')->whereId($id)->first();

    }
}
