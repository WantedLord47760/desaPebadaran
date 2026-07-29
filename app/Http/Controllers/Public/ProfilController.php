<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use App\Models\VisiMisi;
use App\Models\StrukturOrganisasi;
use App\Models\Warga;

class ProfilController extends Controller
{
    public function index()
    {
        $profilData = ProfilDesa::all()->pluck('value', 'key')->toArray();
        $visi = VisiMisi::where('tipe', 'visi')->first();
        $misi = VisiMisi::where('tipe', 'misi')->orderBy('urutan')->get();
        $struktur = StrukturOrganisasi::orderBy('urutan')->get();
        
        // Demografi
        $totalWarga = Warga::count() ?: 1; // avoid div by zero
        $wargaList = Warga::all(['tanggal_lahir']);
        
        $ageGroups = [
            '0-14 Tahun' => 0,
            '15-24 Tahun' => 0,
            '25-54 Tahun' => 0,
            '55+ Tahun' => 0,
        ];
        
        foreach ($wargaList as $w) {
            $age = \Carbon\Carbon::parse($w->tanggal_lahir)->age;
            if ($age <= 14) $ageGroups['0-14 Tahun']++;
            elseif ($age <= 24) $ageGroups['15-24 Tahun']++;
            elseif ($age <= 54) $ageGroups['25-54 Tahun']++;
            else $ageGroups['55+ Tahun']++;
        }
        
        foreach ($ageGroups as $key => $count) {
            $ageGroups[$key] = round(($count / $totalWarga) * 100);
        }

        $demografi = [
            'laki_laki' => Warga::where('jenis_kelamin', 'L')->count(),
            'perempuan' => Warga::where('jenis_kelamin', 'P')->count(),
            'kelompok_umur' => $ageGroups
        ];

        return view('public.profil', [
            'profil' => $profilData,
            'visi' => $visi,
            'misi' => $misi,
            'struktur' => $struktur,
            'demografi' => $demografi
        ]);
    }
}
