<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        try {
            $beritas = Berita::published()->latest()->paginate(6);
        } catch (\Exception $e) {
            $beritas = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 6);
        }
        
        return view('public.berita.index', compact('beritas'));
    }

    public function show($slug)
    {
        try {
            $berita = Berita::published()->where('slug', $slug)->firstOrFail();
        } catch (\Exception $e) {
            abort(404);
        }

        return view('public.berita.show', compact('berita'));
    }
}
