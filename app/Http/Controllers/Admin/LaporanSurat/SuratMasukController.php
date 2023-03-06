<?php

namespace App\Http\Controllers\Admin\LaporanSurat;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\SuratMasukExport;
use App\Http\Controllers\Controller;

class SuratMasukController extends Controller
{
    public function index()
    {
        return view('admin.laporan-surat.surat-masuk.index');
    }

    public function export_excel(Request $request)
    {
        $request->validate([
            "pilih_export" => ["required"],
            "pilih_tanggal" => ["required"],
            "tanggal_awal" => ["required"],
            "tanggal_akhir" => ["required"],
        ]);

        if($request->pilih_export == 'Excel'){
            if($request->pilih_tanggal == 'Tanggal Surat'){
                $data = [
                    'pilih_tanggal' => 'tanggal_surat',
                    'tanggal_awal' => $request->tanggal_awal,
                    'tanggal_akhir' => $request->tanggal_akhir,
                ];
                $from = Carbon::parse($request->tanggal_awal)->translatedFormat('d F Y');
                $to = Carbon::parse($request->tanggal_akhir)->translatedFormat('d F Y');
                return (new SuratMasukExport($data))->download('Surat Masuk '.$from.' SD '.$to.'.xlsx');
            }elseif($request->pilih_tanggal == 'Tanggal Diterima'){
                $data = [
                    'pilih_tanggal' => 'tanggal_diterima',
                    'tanggal_awal' => $request->tanggal_awal,
                    'tanggal_akhir' => $request->tanggal_akhir,
                ];
                $from = Carbon::parse($request->tanggal_awal)->translatedFormat('d F Y');
                $to = Carbon::parse($request->tanggal_akhir)->translatedFormat('d F Y');
                return (new SuratMasukExport($data))->download('Surat Masuk '.$from.' SD '.$to.'.xlsx');
            }
        }elseif($request->pilih_export == 'Csv'){
            if($request->pilih_tanggal == 'Tanggal Surat'){
                $data = [
                    'pilih_tanggal' => 'tanggal_surat',
                    'tanggal_awal' => $request->tanggal_awal,
                    'tanggal_akhir' => $request->tanggal_akhir,
                ];
                $from = Carbon::parse($request->tanggal_awal)->translatedFormat('d F Y');
                $to = Carbon::parse($request->tanggal_akhir)->translatedFormat('d F Y');
                return (new SuratMasukExport($data))->download('Surat Masuk '.$from.' SD '.$to.'.csv');
            }elseif($request->pilih_tanggal == 'Tanggal Diterima'){
                $data = [
                    'pilih_tanggal' => 'tanggal_diterima',
                    'tanggal_awal' => $request->tanggal_awal,
                    'tanggal_akhir' => $request->tanggal_akhir,
                ];
                $from = Carbon::parse($request->tanggal_awal)->translatedFormat('d F Y');
                $to = Carbon::parse($request->tanggal_akhir)->translatedFormat('d F Y');
                return (new SuratMasukExport($data))->download('Surat Masuk '.$from.' SD '.$to.'.csv');
            }
        }
    }
}
