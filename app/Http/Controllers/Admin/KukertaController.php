<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kukerta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KukertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Kukerta::latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                  ->orWhere('pelaksana', 'like', "%{$s}%");
            });
        }

        $kukerta = $query->paginate(10)->withQueryString();

        return view('admin.kukerta.index', compact('kukerta'));
    }

    public function create()
    {
        $categories = Kukerta::categories();
        return view('admin.kukerta.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'              => 'required|string|max:255',
            'konten'             => 'required|string',
            'kategori'           => 'required|string',
            'thumbnail'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'foto_dokumentasi'   => 'nullable|array',
            'foto_dokumentasi.*' => 'image|mimes:jpg,jpeg,png,webp|max:3072',
            'pelaksana'          => 'required|array|min:1',
            'pelaksana.*.nama'   => 'required|string|max:255',
            'pelaksana.*.nim'    => 'nullable|string|max:50',
            'pelaksana.*.universitas' => 'nullable|string|max:255',
            'tanggal_mulai'      => 'nullable|date',
            'tanggal_selesai'    => 'nullable|date|after_or_equal:tanggal_mulai',
            'status'             => 'required|in:Perencanaan,Berjalan,Selesai',
        ]);

        // Thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('kukerta/thumbnails', 'public');
        }

        // Multiple dokumentasi photos
        $fotoPaths = [];
        if ($request->hasFile('foto_dokumentasi')) {
            foreach ($request->file('foto_dokumentasi') as $foto) {
                $fotoPaths[] = $foto->store('kukerta/dokumentasi', 'public');
            }
        }
        $validated['foto_dokumentasi'] = $fotoPaths ?: null;

        // Pelaksana JSON
        $validated['pelaksana'] = array_values(array_filter(
            $request->input('pelaksana', []),
            fn ($p) => !empty($p['nama'])
        ));

        $validated['is_published'] = $request->boolean('is_published');
        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        Kukerta::create($validated);

        return redirect()->route('admin.kukerta.index')
            ->with('success', 'Proker KuKerTa berhasil ditambahkan.');
    }

    public function edit(Kukerta $kukertum)
    {
        $categories = Kukerta::categories();
        return view('admin.kukerta.edit', compact('kukertum', 'categories'));
    }

    public function update(Request $request, Kukerta $kukertum)
    {
        $validated = $request->validate([
            'judul'              => 'required|string|max:255',
            'konten'             => 'required|string',
            'kategori'           => 'required|string',
            'thumbnail'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'foto_dokumentasi'   => 'nullable|array',
            'foto_dokumentasi.*' => 'image|mimes:jpg,jpeg,png,webp|max:3072',
            'pelaksana'          => 'required|array|min:1',
            'pelaksana.*.nama'   => 'required|string|max:255',
            'pelaksana.*.nim'    => 'nullable|string|max:50',
            'pelaksana.*.universitas' => 'nullable|string|max:255',
            'tanggal_mulai'      => 'nullable|date',
            'tanggal_selesai'    => 'nullable|date|after_or_equal:tanggal_mulai',
            'status'             => 'required|in:Perencanaan,Berjalan,Selesai',
        ]);

        // Thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($kukertum->thumbnail) {
                Storage::disk('public')->delete($kukertum->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('kukerta/thumbnails', 'public');
        }

        // Additional documentation photos (append to existing)
        $existingFotos = $kukertum->foto_dokumentasi ?? [];

        // Handle deleted photos (sent as hidden input array of paths to remove)
        $toRemove = $request->input('remove_foto', []);
        foreach ($toRemove as $path) {
            Storage::disk('public')->delete($path);
            $existingFotos = array_values(array_filter($existingFotos, fn ($f) => $f !== $path));
        }

        if ($request->hasFile('foto_dokumentasi')) {
            foreach ($request->file('foto_dokumentasi') as $foto) {
                $existingFotos[] = $foto->store('kukerta/dokumentasi', 'public');
            }
        }
        $validated['foto_dokumentasi'] = $existingFotos ?: null;

        // Pelaksana JSON
        $validated['pelaksana'] = array_values(array_filter(
            $request->input('pelaksana', []),
            fn ($p) => !empty($p['nama'])
        ));

        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published'] && !$kukertum->published_at) {
            $validated['published_at'] = now();
        } elseif (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        $kukertum->update($validated);

        return redirect()->route('admin.kukerta.index')
            ->with('success', 'Proker KuKerTa berhasil diperbarui.');
    }

    public function destroy(Kukerta $kukertum)
    {
        if ($kukertum->thumbnail) {
            Storage::disk('public')->delete($kukertum->thumbnail);
        }
        foreach ($kukertum->foto_dokumentasi ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }

        $kukertum->delete();

        return redirect()->route('admin.kukerta.index')
            ->with('success', 'Proker KuKerTa berhasil dihapus.');
    }

    public function publish(Kukerta $kukertum)
    {
        $kukertum->update([
            'is_published' => true,
            'published_at' => $kukertum->published_at ?? now(),
        ]);

        return redirect()->route('admin.kukerta.index')
            ->with('success', 'Proker berhasil dipublikasikan.');
    }
}
