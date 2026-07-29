<?php

namespace App\Exports;

use App\Models\Warga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WargaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Warga::with('keluarga')->get();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama Lengkap',
            'No KK',
            'Kepala Keluarga',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Pendidikan Terakhir',
            'Pekerjaan',
            'Golongan Darah',
            'Status Perkawinan',
            'Status Dalam Keluarga',
            'Kewarganegaraan'
        ];
    }

    public function map($warga): array
    {
        return [
            $warga->nik,
            $warga->nama,
            $warga->keluarga->no_kk ?? '-',
            $warga->keluarga->kepala_keluarga ?? '-',
            $warga->tempat_lahir,
            $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->format('Y-m-d') : '-',
            $warga->jenis_kelamin,
            $warga->agama,
            $warga->pendidikan_terakhir,
            $warga->pekerjaan,
            $warga->golongan_darah,
            $warga->status_perkawinan,
            $warga->status_dalam_keluarga,
            $warga->kewarganegaraan
        ];
    }
}
