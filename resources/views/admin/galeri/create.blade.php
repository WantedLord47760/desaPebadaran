@extends('layouts.admin')

@section('title', 'Tambah Media Galeri')

@section('content')
<div class="mb-6 flex items-center">
    <a href="{{ route('admin.galeri.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Tambah Media Galeri</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl" x-data="{ tipe: '{{ old('tipe', 'Foto') }}' }">
    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul / Keterangan <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Media <span class="text-red-500">*</span></label>
                <select name="tipe" x-model="tipe" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                    <option value="Foto">Foto</option>
                    <option value="Video">Video</option>
                </select>
            </div>

            <!-- Input untuk Foto -->
            <div x-show="tipe === 'Foto'">
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Foto <span class="text-red-500">*</span></label>
                <input type="file" name="foto_file" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 text-sm bg-gray-50" :required="tipe === 'Foto'">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP (Max 2MB)</p>
            </div>

            <!-- Input untuk Video -->
            <div x-show="tipe === 'Video'" x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-1">URL Video (YouTube dll)</label>
                <input type="url" name="video_url" placeholder="https://youtube.com/watch?v=..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
                
                <div class="text-center my-2 text-sm text-gray-500 font-medium">ATAU</div>
                
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload File Video</label>
                <input type="file" name="video_file" accept="video/mp4,video/webm" class="w-full border border-gray-300 rounded-lg p-2 text-sm bg-gray-50">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Tambahan</label>
                <textarea name="deskripsi" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Urutan Tampil <span class="text-red-500">*</span></label>
                <input type="number" name="urutan" value="{{ old('urutan', 0) }}" class="w-32 rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required min="0">
                <p class="text-xs text-gray-500 mt-1">Angka lebih kecil tampil lebih dulu</p>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.galeri.index') }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-[#2E5090] text-white hover:bg-[#1f3661] px-6 py-2 rounded-lg text-sm font-medium transition-colors">Simpan Media</button>
        </div>
    </form>
</div>
@endsection
