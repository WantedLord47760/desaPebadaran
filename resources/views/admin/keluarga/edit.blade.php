@extends('layouts.admin')

@section('title', 'Edit Keluarga')

@section('content')
<div class="mb-6 flex items-center">
    <a href="{{ route('admin.keluarga.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Edit Data Keluarga</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-3xl">
    <form action="{{ route('admin.keluarga.update', $keluarga->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="no_kk" class="block text-sm font-medium text-gray-700 mb-1">Nomor Kartu Keluarga (KK) <span class="text-red-500">*</span></label>
                <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk', $keluarga->no_kk) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090] @error('no_kk') border-red-500 @enderror" required>
                @error('no_kk')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label for="kepala_keluarga" class="block text-sm font-medium text-gray-700 mb-1">Kepala Keluarga <span class="text-red-500">*</span></label>
                <input type="text" name="kepala_keluarga" id="kepala_keluarga" value="{{ old('kepala_keluarga', $keluarga->kepala_keluarga) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090] @error('kepala_keluarga') border-red-500 @enderror" required>
                @error('kepala_keluarga')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
            <textarea name="alamat" id="alamat" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090] @error('alamat') border-red-500 @enderror" required>{{ old('alamat', $keluarga->alamat) }}</textarea>
            @error('alamat')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div>
                <label for="rt" class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                <input type="text" name="rt" id="rt" value="{{ old('rt', $keluarga->rt) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
            </div>
            
            <div>
                <label for="rw" class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                <input type="text" name="rw" id="rw" value="{{ old('rw', $keluarga->rw) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
            </div>

            <div>
                <label for="dusun" class="block text-sm font-medium text-gray-700 mb-1">Dusun</label>
                <input type="text" name="dusun" id="dusun" value="{{ old('dusun', $keluarga->dusun) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.keluarga.index') }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-[#2E5090] text-white hover:bg-[#1f3661] px-4 py-2 rounded-lg text-sm font-medium transition-colors">Perbarui Data</button>
        </div>
    </form>
</div>
@endsection
