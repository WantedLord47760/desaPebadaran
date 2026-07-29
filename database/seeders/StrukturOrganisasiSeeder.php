<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StrukturOrganisasi;

class StrukturOrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        $struktur = [
            ['nama' => 'NASRUL', 'jabatan' => 'PENGHULU', 'urutan' => 1],
            ['nama' => 'MADI SAPUTRA', 'jabatan' => 'KERANI', 'urutan' => 2],
            ['nama' => 'MANNA SURIATI .H', 'jabatan' => 'KAUR KEUANGAN', 'urutan' => 3],
            ['nama' => 'TURMASARI', 'jabatan' => 'KAUR PERENCANAAN', 'urutan' => 4],
            ['nama' => 'SURYA', 'jabatan' => 'JURU TULIS I', 'urutan' => 5],
            ['nama' => 'SOPAN SOPIAN', 'jabatan' => 'JURU TULIS II', 'urutan' => 6],
            ['nama' => 'MARFU\'AH', 'jabatan' => 'JURU TULIS III', 'urutan' => 7],
            ['nama' => 'WIRAHADI KUSUMA', 'jabatan' => 'KADUS I', 'urutan' => 8],
            ['nama' => 'AMRIZAL', 'jabatan' => 'KADUS II', 'urutan' => 9],
            ['nama' => 'AANDREA', 'jabatan' => 'BAPEKAM', 'urutan' => 10],
        ];

        foreach ($struktur as $item) {
            StrukturOrganisasi::updateOrCreate(
                ['nama' => $item['nama'], 'jabatan' => $item['jabatan']],
                $item
            );
        }
    }
}
