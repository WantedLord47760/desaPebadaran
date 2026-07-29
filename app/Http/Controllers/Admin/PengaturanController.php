<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilDesa;
use App\Models\VisiMisi;
use App\Models\StrukturOrganisasi;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    // PROFIL
    public function profil()
    {
        $profil = ProfilDesa::pluck('value', 'key')->toArray();
        return view('admin.pengaturan.profil', compact('profil'));
    }

    public function updateProfil(Request $request)
    {
        $data = $request->except('_token', '_method', 'logo');
        
        if ($request->hasFile('logo')) {
            $request->validate(['logo' => 'image|mimes:png,jpg,jpeg,webp|max:2048']);
            $path = $request->file('logo')->store('profil', 'public');
            ProfilDesa::updateOrCreate(['key' => 'logo'], ['value' => $path]);
        }

        foreach ($data as $key => $value) {
            ProfilDesa::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return back()->with('success', 'Profil Desa berhasil diperbarui.');
    }

    // VISI MISI
    public function visiMisi()
    {
        $visi = VisiMisi::where('tipe', 'visi')->first();
        $misi = VisiMisi::where('tipe', 'misi')->orderBy('urutan')->get();
        return view('admin.pengaturan.visi-misi', compact('visi', 'misi'));
    }

    public function updateVisiMisi(Request $request)
    {
        $request->validate(['visi' => 'required|string']);
        
        // Update Visi
        VisiMisi::updateOrCreate(
            ['tipe' => 'visi'],
            ['konten' => $request->visi, 'urutan' => 1]
        );

        // Update Misi
        VisiMisi::where('tipe', 'misi')->delete();
        if ($request->has('misi') && is_array($request->misi)) {
            foreach ($request->misi as $index => $konten) {
                if (!empty($konten)) {
                    VisiMisi::create([
                        'tipe' => 'misi',
                        'konten' => $konten,
                        'urutan' => $index + 1
                    ]);
                }
            }
        }
        
        return back()->with('success', 'Visi & Misi berhasil diperbarui.');
    }

    // STRUKTUR ORGANISASI
    public function struktur()
    {
        $struktur = StrukturOrganisasi::orderBy('urutan')->get();
        return view('admin.pengaturan.struktur', compact('struktur'));
    }

    public function updateStruktur(Request $request)
    {
        // This is a simple implementation. A real one might handle individual adds/edits/deletes via API or separate routes
        if ($request->has('new_nama')) {
            $request->validate([
                'new_nama' => 'required|string',
                'new_jabatan' => 'required|string',
                'new_foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
                'new_urutan' => 'required|integer',
            ]);

            $path = $request->file('new_foto')->store('struktur', 'public');
            StrukturOrganisasi::create([
                'nama' => $request->new_nama,
                'jabatan' => $request->new_jabatan,
                'foto' => $path,
                'urutan' => $request->new_urutan,
            ]);
            return back()->with('success', 'Anggota struktur berhasil ditambahkan.');
        }

        if ($request->has('delete_id')) {
            $org = StrukturOrganisasi::findOrFail($request->delete_id);
            if ($org->foto) Storage::disk('public')->delete($org->foto);
            $org->delete();
            return back()->with('success', 'Anggota struktur berhasil dihapus.');
        }

        return back();
    }


    // AKUN ADMIN
    public function akun()
    {
        return view('admin.pengaturan.akun');
    }

    public function updateAkun(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }
}
