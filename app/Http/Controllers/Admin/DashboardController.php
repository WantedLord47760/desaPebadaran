<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// We will assume these models exist as requested
use App\Models\Warga;
use App\Models\Keluarga;
use App\Models\Berita;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate stats
        $totalPenduduk = class_exists(Warga::class) ? Warga::count() : 0;
        $totalKK = class_exists(Keluarga::class) ? Keluarga::count() : 0;
        $lakiLaki = class_exists(Warga::class) ? Warga::where('jenis_kelamin', 'L')->count() : 0;
        $perempuan = class_exists(Warga::class) ? Warga::where('jenis_kelamin', 'P')->count() : 0;

        // Age group calculation (rough estimate if DOB is used)
        $ageGroups = [
            '0-14' => 0,
            '15-24' => 0,
            '25-54' => 0,
            '55+' => 0,
        ];
        
        if (class_exists(Warga::class) && \Schema::hasColumn('wargas', 'tanggal_lahir')) {
            $wargas = Warga::select('tanggal_lahir')->get();
            foreach($wargas as $warga) {
                if($warga->tanggal_lahir) {
                    $age = Carbon::parse($warga->tanggal_lahir)->age;
                    if($age <= 14) $ageGroups['0-14']++;
                    elseif($age <= 24) $ageGroups['15-24']++;
                    elseif($age <= 54) $ageGroups['25-54']++;
                    else $ageGroups['55+']++;
                }
            }
        }

        $latestBerita = class_exists(Berita::class) ? Berita::latest()->take(5)->get() : collect([]);

        $stats = [
            'totalPenduduk' => $totalPenduduk,
            'totalKK' => $totalKK,
            'lakiLaki' => $lakiLaki,
            'perempuan' => $perempuan,
            'ageGroups' => $ageGroups,
            'latestBerita' => $latestBerita,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
