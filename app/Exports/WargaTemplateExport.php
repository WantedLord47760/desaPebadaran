<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WargaTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'nik',
            'nama',
            'no_kk',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'agama',
            'pendidikan_terakhir',
            'pekerjaan',
            'golongan_darah',
            'status_perkawinan',
            'status_dalam_keluarga',
            'kewarganegaraan'
        ];
    }

    public function array(): array
    {
        return [
            [
                '1408011203850001',
                'Ahmad Subagyo',
                '1408010101180001',
                'Siak',
                '1985-03-12',
                'L',
                'Islam',
                'SLTA',
                'Petani / Pekebun',
                'O',
                'Kawin',
                'Kepala Keluarga',
                'WNI'
            ],
            [
                '1408014506880002',
                'Siti Aminah',
                '1408010101180001',
                'Pebadaran',
                '1988-06-15',
                'P',
                'Islam',
                'SLTP',
                'Ibu Rumah Tangga',
                'A',
                'Kawin',
                'Istri',
                'WNI'
            ],
            [
                '1408011010100003',
                'Budi Santoso',
                '1408010101180001',
                'Pebadaran',
                '2010-10-10',
                'L',
                'Islam',
                'SD',
                'Pelajar / Mahasiswa',
                'O',
                'Belum Kawin',
                'Anak',
                'WNI'
            ],
            [
                '1408012001920004',
                'Rina Wulandari',
                '1408010101180002',
                'Pekanbaru',
                '1992-01-20',
                'P',
                'Islam',
                'S1',
                'Guru',
                'B',
                'Kawin',
                'Kepala Keluarga',
                'WNI'
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0F1D3A']
                ]
            ],
        ];
    }
}
