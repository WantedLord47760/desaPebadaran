<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Galeri::orderBy('urutan')->latest();
            
            if ($request->has('tipe') && in_array($request->tipe, ['foto', 'video'])) {
                $query->where('tipe', $request->tipe);
            }
            
            $galeris = $query->get();
        } catch (\Exception $e) {
            $galeris = collect([]);
        }

        return view('public.galeri', compact('galeris'));
    }
}
