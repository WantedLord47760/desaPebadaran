<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->paginate(10);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'konten' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('berita', 'public');
            $validated['thumbnail'] = $path;
        }

        $validated['slug'] = Str::slug($validated['judul']);
        $validated['is_published'] = $request->has('is_published');
        $validated['author_id'] = auth()->id();
        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        Berita::create($validated);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $beritum) // Laravel sometimes pluralizes 'berita' to 'berita' and variable as $beritum or $berita
    {
        return view('admin.berita.edit', ['berita' => $beritum]);
    }

    public function update(Request $request, Berita $beritum)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'konten' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($beritum->thumbnail) {
                Storage::disk('public')->delete($beritum->thumbnail);
            }
            $path = $request->file('thumbnail')->store('berita', 'public');
            $validated['thumbnail'] = $path;
        }

        $validated['slug'] = Str::slug($validated['judul']);
        $validated['is_published'] = $request->has('is_published');
        
        if ($validated['is_published'] && !$beritum->published_at) {
            $validated['published_at'] = now();
        } elseif (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        $beritum->update($validated);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $beritum)
    {
        if ($beritum->thumbnail) {
            Storage::disk('public')->delete($beritum->thumbnail);
        }
        $beritum->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function publish(Berita $beritum)
    {
        $beritum->update([
            'is_published' => true,
            'published_at' => $beritum->published_at ?? now(),
        ]);
        
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dipublikasikan.');
    }
}
