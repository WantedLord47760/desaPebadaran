<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Keluarga;
use App\Exports\WargaExport;
use App\Exports\WargaTemplateExport;
use App\Imports\WargaImport;
use Maatwebsite\Excel\Facades\Excel;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Warga::with('keluarga');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
        }
        
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('keluarga_id')) {
            $query->where('keluarga_id', $request->keluarga_id);
        }

        $warga = $query->paginate(15)->withQueryString();
        
        return view('admin.warga.index', compact('warga'));
    }

    public function create(Request $request)
    {
        $keluarga = Keluarga::orderBy('no_kk')->get();
        $selectedKeluarga = $request->keluarga_id;
        return view('admin.warga.create', compact('keluarga', 'selectedKeluarga'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:warga,nik',
            'nama' => 'required|string|max:255',
            'keluarga_id' => 'required|exists:keluarga,id',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'golongan_darah' => 'nullable|string',
            'status_perkawinan' => 'required|string',
            'status_hubungan_dalam_keluarga' => 'required|string',
            'kewarganegaraan' => 'required|string',
        ]);

        Warga::create($validated);
        return redirect()->route('admin.warga.index')->with('success', 'Data Warga berhasil ditambahkan.');
    }

    public function edit(Warga $warga)
    {
        $keluarga = Keluarga::orderBy('no_kk')->get();
        return view('admin.warga.edit', compact('warga', 'keluarga'));
    }

    public function update(Request $request, Warga $warga)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:warga,nik,' . $warga->id,
            'nama' => 'required|string|max:255',
            'keluarga_id' => 'required|exists:keluarga,id',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'golongan_darah' => 'nullable|string',
            'status_perkawinan' => 'required|string',
            'status_hubungan_dalam_keluarga' => 'required|string',
            'kewarganegaraan' => 'required|string',
        ]);

        $warga->update($validated);
        return redirect()->route('admin.warga.index')->with('success', 'Data Warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();
        return redirect()->route('admin.warga.index')->with('success', 'Data Warga berhasil dihapus.');
    }

    public function showImport()
    {
        return view('admin.warga.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:2048'
        ]);

        try {
            Excel::import(new WargaImport, $request->file('file'));
            return redirect()->route('admin.warga.index')->with('success', 'Data Warga berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new WargaExport, 'data-warga-desa-pebadaran.xlsx');
    }

    public function downloadTemplate()
    {
        return Excel::download(new WargaTemplateExport, 'template-import-warga-desa-pebadaran.xlsx');
    }
}
