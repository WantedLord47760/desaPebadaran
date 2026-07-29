<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $query = Galeri::orderBy('urutan')->latest();
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        $galeri = $query->paginate(12)->withQueryString();
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:Foto,Video',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer|min:0',
        ]);

        if ($request->tipe === 'Foto') {
            $request->validate(['foto_file' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048']);
            $validated['file_path'] = $request->file('foto_file')->store('galeri', 'public');
        } else {
            // Video can be URL or file, let's assume URL for simplicity or handle both
            if ($request->hasFile('video_file')) {
                $request->validate(['video_file' => 'required|mimes:mp4,webm|max:20480']); // 20MB
                $validated['file_path'] = $request->file('video_file')->store('galeri', 'public');
            } else {
                $request->validate(['video_url' => 'required|url']);
                $validated['file_path'] = $request->video_url;
            }
        }

        Galeri::create($validated);
        return redirect()->route('admin.galeri.index')->with('success', 'Item galeri berhasil ditambahkan.');
    }

    public function destroy(Galeri $galeri)
    {
        if ($galeri->tipe === 'Foto' || !filter_var($galeri->file_path, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($galeri->file_path);
        }
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Item galeri berhasil dihapus.');
    }
}
