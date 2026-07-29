<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $query = Umkm::where('is_active', true)->latest();
        
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        $umkms = $query->paginate(12);
        
        $categories = Umkm::where('is_active', true)->distinct()->pluck('kategori');

        return view('public.umkm.index', compact('umkms', 'categories'));
    }

    public function show($id)
    {
        $umkm = Umkm::where('is_active', true)->findOrFail($id);

        return view('public.umkm.show', compact('umkm'));
    }
}
