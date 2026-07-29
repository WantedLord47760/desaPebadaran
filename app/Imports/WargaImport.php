<?php

namespace App\Imports;

use App\Models\Warga;
use App\Models\Keluarga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class WargaImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $no_kk = isset($row['no_kk']) ? trim((string) $row['no_kk']) : '';
        $nik = isset($row['nik']) ? trim((string) $row['nik']) : '';

        if (empty($nik) || empty($row['nama'])) {
            return null;
        }

        // Lookup keluarga by no_kk
        $keluarga = Keluarga::where('no_kk', $no_kk)->first();
        
        if (!$keluarga && !empty($no_kk)) {
            // Auto-create keluarga if it doesn't exist
            $keluarga = Keluarga::create([
                'no_kk' => $no_kk,
                'kepala_keluarga' => $row['nama'] ?? 'Kepala Keluarga',
                'alamat' => '-'
            ]);
        }

        // Handle Excel date format
        $tanggal_lahir = null;
        if (isset($row['tanggal_lahir'])) {
            if (is_numeric($row['tanggal_lahir'])) {
                $tanggal_lahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');
            } else {
                try {
                    $tanggal_lahir = Carbon::parse($row['tanggal_lahir'])->format('Y-m-d');
                } catch (\Exception $e) {
                    $tanggal_lahir = null;
                }
            }
        }

        // Normalize enum inputs
        $pendidikanRaw = $row['pendidikan_terakhir'] ?? $row['pendidikan'] ?? 'Tidak/Belum Sekolah';
        $pendidikan = $this->parsePendidikan($pendidikanRaw);

        $shdkRaw = $row['status_dalam_keluarga'] ?? $row['shdk'] ?? $row['status_hubungan_dalam_keluarga'] ?? 'Anak';
        $shdk = $this->parseShdk($shdkRaw);

        $golDarahRaw = strtoupper(trim($row['golongan_darah'] ?? ''));
        $golDarah = in_array($golDarahRaw, ['A', 'B', 'AB', 'O']) ? $golDarahRaw : null;

        $jk = strtoupper(trim($row['jenis_kelamin'] ?? 'L')) === 'P' ? 'P' : 'L';

        return new Warga([
            'nik' => $nik,
            'nama' => $row['nama'],
            'keluarga_id' => $keluarga->id ?? null,
            'tempat_lahir' => $row['tempat_lahir'] ?? '-',
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jk,
            'agama' => $row['agama'] ?? 'Islam',
            'pendidikan_terakhir' => $pendidikan,
            'status_perkawinan' => $row['status_perkawinan'] ?? 'Belum Kawin',
            'pekerjaan' => $row['pekerjaan'] ?? 'Belum/Tidak Bekerja',
            'status_dalam_keluarga' => $shdk,
            'golongan_darah' => $golDarah,
            'is_active' => true,
        ]);
    }

    private function parsePendidikan($val): string
    {
        $v = strtoupper(trim((string)$val));
        if (str_contains($v, 'SLTA') || str_contains($v, 'SMA') || str_contains($v, 'SMK') || str_contains($v, 'MA')) return 'SLTA';
        if (str_contains($v, 'SLTP') || str_contains($v, 'SMP') || str_contains($v, 'MTS')) return 'SLTP';
        if (str_contains($v, 'SD')) return 'SD';
        if (str_contains($v, 'S1') || str_contains($v, 'SARJANA')) return 'S1';
        if (str_contains($v, 'S2')) return 'S2';
        if (str_contains($v, 'S3')) return 'S3';
        if (str_contains($v, 'DIPLOMA') || str_contains($v, 'D3') || str_contains($v, 'D4')) return 'Diploma';
        if (str_contains($v, 'BELUM TAMAT')) return 'Belum Tamat SD';
        return 'Tidak/Belum Sekolah';
    }

    private function parseShdk($val): string
    {
        $v = strtolower(trim((string)$val));
        if (str_contains($v, 'kepala') || str_contains($v, 'suami')) return 'Kepala Keluarga';
        if (str_contains($v, 'istri')) return 'Istri';
        if (str_contains($v, 'anak')) return 'Anak';
        if (str_contains($v, 'famili')) return 'Famili Lain';
        return 'Lainnya';
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|unique:warga,nik',
            'nama' => 'required',
            'no_kk' => 'required',
        ];
    }
}
