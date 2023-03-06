<?php

namespace App\Exports;

use App\Models\SuratKeluar;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuratKeluarExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function query()
    {
        return SuratKeluar::query()->whereBetween($this->data['pilih_tanggal'],[$this->data['tanggal_awal'],$this->data['tanggal_akhir']]);
    }

    public function map($surat_keluar): array
    {
        return [
            $surat_keluar->nomor_agenda,
            $surat_keluar->nomor_surat,
            $surat_keluar->nama_surat,
            $surat_keluar->ditujukan_kepada,
            $surat_keluar->status_approve,
            Carbon::parse($surat_keluar->tanggal_surat)->translatedFormat('d F Y'),
            Carbon::parse($surat_keluar->tanggal_keluar)->translatedFormat('d F Y'),
            $surat_keluar->perihal,
        ];
    }

    public function headings(): array
    {
        return [
            'Nomor Agenda',
            'Nomor Surat',
            'Nama Surat',
            'Ditujukan Kepada',
            'Status',
            'Tanggal Surat',
            'Tanggal Keluar',
            'Perihal',
        ];
    }
}
