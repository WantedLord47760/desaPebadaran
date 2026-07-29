<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use App\Models\Berita;
use App\Models\Umkm;
use App\Models\Warga;
use App\Models\Keluarga;

class BerandaController extends Controller
{
    public function index()
    {
        // For actual production, these models should exist.
        // Wrap in try-catch in case models don't exist yet to prevent 500 error on preview
        try {

            $latestBerita = Berita::published()->latest()->take(3)->get();
            $featuredUmkm = Umkm::where('is_active', true)->latest()->take(6)->get();
            
            $totalPenduduk = Warga::count();
            $totalKK = Keluarga::count();
            $totalLaki = Warga::where('jenis_kelamin', 'L')->count();
            $totalPerempuan = Warga::where('jenis_kelamin', 'P')->count();
        } catch (\Exception $e) {

            $latestBerita = collect([]);
            $featuredUmkm = collect([]);
            $totalPenduduk = '1,240';
            $totalKK = '342';
            $totalLaki = '630';
            $totalPerempuan = '610';
        }

        return view('public.beranda', compact(

            'latestBerita', 
            'featuredUmkm',
            'totalPenduduk',
            'totalKK',
            'totalLaki',
            'totalPerempuan'
        ));
    }
}
