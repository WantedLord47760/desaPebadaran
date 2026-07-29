<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kukerta;
use Illuminate\Http\Request;

class KukertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Kukerta::published()->latest('published_at');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pelaksana', 'like', "%{$search}%");
            });
        }

        $projects  = $query->paginate(9)->withQueryString();
        $categories = Kukerta::categories();

        $stats = [
            'total'    => Kukerta::published()->count(),
            'selesai'  => Kukerta::published()->where('status', 'Selesai')->count(),
            'berjalan' => Kukerta::published()->where('status', 'Berjalan')->count(),
        ];

        return view('public.kukerta.index', compact('projects', 'categories', 'stats'));
    }

    public function show(string $slug)
    {
        $project = Kukerta::published()->where('slug', $slug)->firstOrFail();

        $related = Kukerta::published()
            ->where('id', '!=', $project->id)
            ->where('kategori', $project->kategori)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('public.kukerta.show', compact('project', 'related'));
    }
}
