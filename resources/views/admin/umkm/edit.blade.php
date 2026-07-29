@extends('layouts.admin')

@section('title', 'Edit Produk UMKM')

@section('content')
<div class="mb-6 flex items-center">
    <a href="{{ route('admin.umkm.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Edit Produk UMKM</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-4xl">
    <form action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Kolom Kiri -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk', $umkm->nama_produk) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                        @foreach(['Makanan', 'Minuman', 'Kerajinan', 'Pakaian', 'Agrikultur', 'Jasa', 'Lainnya'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori', $umkm->kategori) == $kat ? 'selected' : '' }}>{{ $kat == 'Kerajinan' ? 'Kerajinan Tangan' : ($kat == 'Pakaian' ? 'Pakaian / Fashion' : ($kat == 'Agrikultur' ? 'Agrikultur / Pertanian' : $kat)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="harga" value="{{ old('harga', $umkm->harga) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" rows="5" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
                    
                    @if($umkm->foto)
                    <div class="mb-3 rounded-lg overflow-hidden border">
                        <img src="{{ Storage::url($umkm->foto) }}" alt="Foto saat ini" class="w-full h-auto max-h-48 object-cover">
                        <p class="text-xs text-center p-1 bg-gray-50 text-gray-500">Foto saat ini</p>
                    </div>
                    @endif

                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-[#2E5090] hover:text-blue-800 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#2E5090]">
                                    <span>Ganti file</span>
                                    <input id="foto" name="foto" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengubah foto</p>
                        </div>
                    </div>
                    <div id="imagePreview" class="mt-4 hidden w-full rounded-lg overflow-hidden shadow-sm border border-gray-200">
                        <img id="preview" src="#" alt="Preview" class="w-full h-auto object-cover max-h-48">
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="font-medium text-gray-800 mb-4 pb-2 border-b">Informasi Penjual</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penjual / Toko <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_penjual" value="{{ old('nama_penjual', $umkm->nama_penjual) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp <span class="text-red-500">*</span></label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-500 sm:text-sm">
                                    +62
                                </span>
                                <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $umkm->no_whatsapp) }}" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-lg border-gray-300 focus:border-[#2E5090] focus:ring-[#2E5090] sm:text-sm" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $umkm->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-[#2E5090] shadow-sm focus:border-[#2E5090] focus:ring focus:ring-[#2E5090] focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700 font-medium">Tampilkan produk ini di halaman publik (Aktif)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.umkm.index') }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-[#2E5090] text-white hover:bg-[#1f3661] px-6 py-2 rounded-lg text-sm font-medium transition-colors">Perbarui Produk</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
