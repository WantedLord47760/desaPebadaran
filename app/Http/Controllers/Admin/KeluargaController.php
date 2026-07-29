<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga;

class KeluargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Keluarga::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('no_kk', 'like', "%{$search}%")
                  ->orWhere('kepala_keluarga', 'like', "%{$search}%");
        }
        $keluarga = $query->paginate(15)->withQueryString();
        
        return view('admin.keluarga.index', compact('keluarga'));
    }

    public function create()
    {
        return view('admin.keluarga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|unique:keluarga,no_kk',
            'kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'dusun' => 'nullable|string|max:100',
        ]);

        Keluarga::create($validated);
        return redirect()->route('admin.keluarga.index')->with('success', 'Data Keluarga berhasil ditambahkan.');
    }

    public function show(Keluarga $keluarga)
    {
        $keluarga->load('warga'); // Eager load family members
        return view('admin.keluarga.show', compact('keluarga'));
    }

    public function edit(Keluarga $keluarga)
    {
        return view('admin.keluarga.edit', compact('keluarga'));
    }

    public function update(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|unique:keluarga,no_kk,' . $keluarga->id,
            'kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'dusun' => 'nullable|string|max:100',
        ]);

        $keluarga->update($validated);
        return redirect()->route('admin.keluarga.index')->with('success', 'Data Keluarga berhasil diperbarui.');
    }

    public function destroy(Keluarga $keluarga)
    {
        $keluarga->delete();
        return redirect()->route('admin.keluarga.index')->with('success', 'Data Keluarga berhasil dihapus.');
    }
}
