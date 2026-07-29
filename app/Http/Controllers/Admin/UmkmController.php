<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Umkm;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    public function index()
    {
        $umkm = Umkm::latest()->paginate(10);
        return view('admin.umkm.index', compact('umkm'));
    }

    public function create()
    {
        return view('admin.umkm.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nama_penjual' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Umkm::create($validated);
        return redirect()->route('admin.umkm.index')->with('success', 'Produk UMKM berhasil ditambahkan.');
    }

    public function edit(Umkm $umkm)
    {
        return view('admin.umkm.edit', compact('umkm'));
    }

    public function update(Request $request, Umkm $umkm)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nama_penjual' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            if ($umkm->foto) {
                Storage::disk('public')->delete($umkm->foto);
            }
            $validated['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $umkm->update($validated);
        return redirect()->route('admin.umkm.index')->with('success', 'Produk UMKM berhasil diperbarui.');
    }

    public function destroy(Umkm $umkm)
    {
        if ($umkm->foto) {
            Storage::disk('public')->delete($umkm->foto);
        }
        $umkm->delete();
        return redirect()->route('admin.umkm.index')->with('success', 'Produk UMKM berhasil dihapus.');
    }
}
