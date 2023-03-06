<?php

namespace App\Http\Controllers\Admin\ArsipSurat;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surat_keluar = true;
        return view('admin.arsip-surat.surat-keluar.index',compact('surat_keluar'));
    }

    public function search(Request $request)
    {
        $request->validate([
            "pilih_tanggal" => ["required"],
            "tanggal_awal" => ["required"],
            "tanggal_akhir" => ["required"],
        ]);

        if($request->pilih_tanggal == 'Tanggal Surat'){
            $surat_keluar = SuratKeluar::with('file_surat_keluar','akses_surat_keluar')
                ->whereBetween('tanggal_surat',[$request->tanggal_awal,$request->tanggal_akhir])
                ->get();
        }elseif($request->pilih_tanggal == 'Tanggal Keluar'){
            $surat_keluar = SuratKeluar::with('file_surat_keluar','akses_surat_keluar')
            ->whereBetween('tanggal_keluar',[$request->tanggal_awal,$request->tanggal_akhir])
            ->get();
        }else{
            $surat_keluar = null;
        }

        return view('admin.arsip-surat.surat-keluar.show',compact('surat_keluar'));
    }
}
