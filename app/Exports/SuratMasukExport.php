<?php

namespace App\Exports;

use App\Models\SuratMasuk;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuratMasukExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function query()
    {
        return SuratMasuk::query()->whereBetween($this->data['pilih_tanggal'],[$this->data['tanggal_awal'],$this->data['tanggal_akhir']]);
    }

    public function map($surat_masuk): array
    {
        return [
            $surat_masuk->nomor_agenda,
            $surat_masuk->nomor_surat,
            $surat_masuk->nama_surat,
            Carbon::parse($surat_masuk->tanggal_surat)->translatedFormat('d F Y'),
            Carbon::parse($surat_masuk->tanggal_diterima)->translatedFormat('d F Y'),
            $surat_masuk->perihal,
        ];
    }

    public function headings(): array
    {
        return [
            'Nomor Agenda',
            'Nomor Surat',
            'Nama Surat',
            'Tanggal Surat',
            'Tanggal Diterima',
            'Perihal',
        ];
    }
}
