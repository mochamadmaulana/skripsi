<?php

namespace App\Http\Controllers\Admin\ArsipSurat;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index()
    {
        $surat_masuk = true;
        return view('admin.arsip-surat.surat-masuk.index',[
            'surat_masuk' => $surat_masuk,
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            "pilih_tanggal" => ["required"],
            "tanggal_awal" => ["required"],
            "tanggal_akhir" => ["required"],
        ]);

        if($request->pilih_tanggal == 'Tanggal Surat'){
            $surat_masuk = SuratMasuk::with('file_surat_masuk','akses_surat_masuk')
                ->whereBetween('tanggal_surat',[$request->tanggal_awal,$request->tanggal_akhir])
                ->get();
        }elseif($request->pilih_tanggal == 'Tanggal Diterima'){
            $surat_masuk = SuratMasuk::with('file_surat_masuk','akses_surat_masuk')
            ->whereBetween('tanggal_diterima',[$request->tanggal_awal,$request->tanggal_akhir])
            ->get();
        }else{
            $surat_masuk = null;
        }

        return view('admin.arsip-surat.surat-masuk.show',compact('surat_masuk'));
    }
}
