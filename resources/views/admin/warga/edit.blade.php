@extends('layouts.admin')

@section('title', 'Edit Warga')

@section('content')
<div class="mb-6 flex items-center">
    <a href="{{ route('admin.warga.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Edit Data Warga: {{ $warga->nama }}</h2>
</div>

<form action="{{ route('admin.warga.update', $warga->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Dasar & Keluarga</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Keluarga (KK) <span class="text-red-500">*</span></label>
                <select name="keluarga_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                    @foreach($keluarga as $kk)
                        <option value="{{ $kk->id }}" {{ (old('keluarga_id', $warga->keluarga_id) == $kk->id) ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                    @endforeach
                </select>
                @error('keluarga_id')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status dalam Keluarga <span class="text-red-500">*</span></label>
                <select name="status_hubungan_dalam_keluarga" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                    @foreach(['Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Lainnya'] as $shdk)
                        <option value="{{ $shdk }}" {{ old('status_hubungan_dalam_keluarga', $warga->status_hubungan_dalam_keluarga) == $shdk ? 'selected' : '' }}>{{ $shdk }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIK <span class="text-red-500">*</span></label>
                <input type="text" name="nik" value="{{ old('nik', $warga->nik) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" maxlength="16" required>
                @error('nik')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $warga->nama) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                @error('nama')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Detail Personal</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->format('Y-m-d') : '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                    <option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Agama <span class="text-red-500">*</span></label>
                <select name="agama" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                        <option value="{{ $agama }}" {{ old('agama', $warga->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Golongan Darah</label>
                <select name="golongan_darah" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
                    @foreach(['', 'A', 'B', 'AB', 'O'] as $goldar)
                        <option value="{{ $goldar }}" {{ old('golongan_darah', $warga->golongan_darah) == $goldar ? 'selected' : '' }}>{{ $goldar == '' ? 'Tidak Tahu / -' : $goldar }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Perkawinan <span class="text-red-500">*</span></label>
                <select name="status_perkawinan" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                    @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                        <option value="{{ $status }}" {{ old('status_perkawinan', $warga->status_perkawinan) == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan <span class="text-red-500">*</span></label>
                <input type="text" name="pendidikan" value="{{ old('pendidikan', $warga->pendidikan) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan <span class="text-red-500">*</span></label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kewarganegaraan <span class="text-red-500">*</span></label>
                <select name="kewarganegaraan" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                    <option value="WNI" {{ old('kewarganegaraan', $warga->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>WNI</option>
                    <option value="WNA" {{ old('kewarganegaraan', $warga->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>WNA</option>
                </select>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-3 mb-10">
        <a href="{{ route('admin.warga.index') }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Batal</a>
        <button type="submit" class="bg-[#2E5090] text-white hover:bg-[#1f3661] px-4 py-2 rounded-lg text-sm font-medium transition-colors">Perbarui Data Warga</button>
    </div>
</form>
@endsection
