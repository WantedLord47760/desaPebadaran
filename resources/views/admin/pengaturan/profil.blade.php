@extends('layouts.admin')

@section('title', 'Profil Desa')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Pengaturan Profil Desa</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form action="{{ route('admin.pengaturan.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Umum</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo Desa (Opsional)</label>
                    @if(isset($profil['logo']) && $profil['logo'])
                        <div class="mb-2">
                            <img src="{{ Storage::url($profil['logo']) }}" alt="Logo Desa" class="h-16 w-auto object-contain bg-gray-100 p-2 rounded">
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] p-1 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Desa</label>
                    <input type="text" name="nama_desa" value="{{ $profil['nama_desa'] ?? 'Pebadaran' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <input type="text" name="kecamatan" value="{{ $profil['kecamatan'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten</label>
                    <input type="text" name="kabupaten" value="{{ $profil['kabupaten'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                    <input type="text" name="provinsi" value="{{ $profil['provinsi'] ?? 'Riau' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">
                </div>
            </div>
            
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Geografis & Kontak</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Luas Wilayah</label>
                    <input type="text" name="luas_wilayah" value="{{ $profil['luas_wilayah'] ?? '' }}" placeholder="Contoh: 16,22 km²" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titik Koordinat (Maps)</label>
                    <input type="text" name="koordinat" value="{{ $profil['koordinat'] ?? '' }}" placeholder="-0.1234, 101.5678" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Kantor Desa</label>
                    <textarea name="alamat_kantor" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">{{ $profil['alamat_kantor'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <div class="mb-8 space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Batas Wilayah</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Utara</label>
                    <input type="text" name="batas_utara" value="{{ $profil['batas_utara'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Timur</label>
                    <input type="text" name="batas_timur" value="{{ $profil['batas_timur'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Selatan</label>
                    <input type="text" name="batas_selatan" value="{{ $profil['batas_selatan'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Barat</label>
                    <input type="text" name="batas_barat" value="{{ $profil['batas_barat'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Sejarah Desa</h3>
            <textarea name="sejarah" id="sejarah" rows="10" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]">{{ $profil['sejarah'] ?? '' }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-[#2E5090] text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-[#1f3661] transition-colors">Simpan Profil Desa</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#sejarah',
        height: 450,
        menubar: false,
        plugins: ['advlist','autolink','lists','link','image','charmap','preview','anchor','searchreplace','visualblocks','code','fullscreen','insertdatetime','media','table','help','wordcount'],
        toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:16px }'
    });
</script>
@endpush
