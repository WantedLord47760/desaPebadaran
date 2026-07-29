@extends('layouts.admin')

@section('title', 'Struktur Organisasi')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Struktur Organisasi Desa</h2>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Tambah -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Tambah Perangkat Desa</h3>
            <form action="{{ route('admin.pengaturan.struktur.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                    <input type="text" name="new_nama" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] text-sm" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="new_jabatan" placeholder="Contoh: Kepala Desa" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] text-sm" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto <span class="text-red-500">*</span></label>
                    <input type="file" name="new_foto" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 text-sm bg-gray-50" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutan Tampil <span class="text-red-500">*</span></label>
                    <input type="number" name="new_urutan" value="1" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] text-sm" required>
                    <p class="text-xs text-gray-500 mt-1">1 = Paling Atas (Kades)</p>
                </div>

                <button type="submit" class="w-full bg-[#2E5090] text-white py-2 rounded-lg text-sm font-medium hover:bg-[#1f3661] transition-colors">Tambahkan</button>
            </form>
        </div>
    </div>

    <!-- Daftar Struktur -->
    <div class="lg:col-span-2">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($struktur as $org)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden border-b relative">
                    <img src="{{ Storage::url($org->foto) }}" alt="{{ $org->nama }}" class="w-full h-full object-cover object-top">
                    <div class="absolute top-2 left-2 bg-black/60 text-white text-xs px-2 py-1 rounded">Urutan: {{ $org->urutan }}</div>
                </div>
                <div class="p-4 flex-1 flex flex-col justify-between text-center">
                    <div>
                        <h4 class="font-bold text-gray-900 text-lg">{{ $org->nama }}</h4>
                        <p class="text-[#2E5090] font-medium text-sm">{{ $org->jabatan }}</p>
                    </div>
                    
                    <div class="mt-4 pt-3 border-t">
                        <form action="{{ route('admin.pengaturan.struktur.update') }}" method="POST" onsubmit="return confirm('Hapus perangkat desa ini?');">
                            @csrf @method('PUT')
                            <input type="hidden" name="delete_id" value="{{ $org->id }}">
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm inline-flex items-center font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-xl shadow-sm border border-gray-100 border-dashed p-12 text-center text-gray-500">
                <p>Belum ada data struktur organisasi.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
