@extends('layouts.admin')
@section('title', 'Tambah Proker KUKERTA')

@section('content')
<div class="mb-6 flex items-center">
    <a href="{{ route('admin.kukerta.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Tambah Proker KUKERTA</h2>
</div>

<form action="{{ route('admin.kukerta.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Kolom Kiri: Konten Utama ── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Judul & Konten --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Program Kerja <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                    @error('judul')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi / Isi Laporan <span class="text-red-500">*</span></label>
                    <textarea name="konten" id="konten" class="w-full rounded-lg border-gray-300 shadow-sm">{{ old('konten') }}</textarea>
                    @error('konten')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Pelaksana (Multi-row) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" x-data="pelaksanaForm()">
                <div class="flex items-center justify-between mb-4 pb-3 border-b">
                    <h3 class="text-sm font-semibold text-gray-800">Pelaksana Program Kerja <span class="text-red-500">*</span></h3>
                    <button type="button" @click="add()" class="text-xs bg-[#2E5090]/10 text-[#2E5090] hover:bg-[#2E5090]/20 px-3 py-1.5 rounded-lg font-medium flex items-center gap-1 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Pelaksana
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(item, index) in rows" :key="index">
                        <div class="grid grid-cols-12 gap-3 items-start p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="col-span-12 sm:col-span-5">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Nama Lengkap *</label>
                                <input type="text" :name="'pelaksana[' + index + '][nama]'" x-model="item.nama"
                                       class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-[#2E5090] focus:ring-[#2E5090]"
                                       placeholder="Nama mahasiswa" required>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-xs font-medium text-gray-600 mb-1">NIM</label>
                                <input type="text" :name="'pelaksana[' + index + '][nim]'" x-model="item.nim"
                                       class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-[#2E5090] focus:ring-[#2E5090]"
                                       placeholder="NIM">
                            </div>
                            <div class="col-span-5 sm:col-span-3">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Universitas</label>
                                <input type="text" :name="'pelaksana[' + index + '][universitas]'" x-model="item.universitas"
                                       class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-[#2E5090] focus:ring-[#2E5090]"
                                       placeholder="Universitas">
                            </div>
                            <div class="col-span-1 flex items-end justify-center pb-1">
                                <button type="button" @click="remove(index)" x-show="rows.length > 1"
                                        class="text-red-400 hover:text-red-600 transition-colors mt-5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
                @error('pelaksana')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Foto Dokumentasi (Multi) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 pb-3 border-b">Foto Dokumentasi <span class="text-gray-400 font-normal text-xs">(bisa lebih dari 1)</span></h3>

                <div class="flex items-center justify-center w-full mb-4">
                    <label for="foto_dokumentasi" class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm text-gray-500"><span class="font-semibold text-[#2E5090]">Klik untuk upload</span> atau drag & drop</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP – maks 3MB per foto – bisa pilih beberapa sekaligus</p>
                        </div>
                        <input id="foto_dokumentasi" type="file" name="foto_dokumentasi[]" class="hidden" accept="image/*" multiple onchange="previewMultiple(event)">
                    </label>
                </div>

                <div id="previewGrid" class="grid grid-cols-3 sm:grid-cols-4 gap-3"></div>
                @error('foto_dokumentasi')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror
                @error('foto_dokumentasi.*')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- ── Kolom Kanan: Sidebar ── --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Pengaturan --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 pb-2 border-b">Pengaturan Publikasi</h3>

                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="rounded border-gray-300 text-[#2E5090] shadow-sm focus:ring-[#2E5090]">
                        <span class="text-sm text-gray-700">Publikasikan Langsung</span>
                    </label>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" @selected(old('kategori') === $cat)>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('kategori')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
                        @foreach(['Perencanaan', 'Berjalan', 'Selesai'] as $s)
                            <option value="{{ $s }}" @selected(old('status', 'Selesai') === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
                </div>
            </div>

            {{-- Thumbnail --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 pb-2 border-b">Thumbnail / Foto Cover</h3>
                <div class="flex items-center justify-center w-full">
                    <label for="thumbnail" class="flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg>
                            <p class="text-sm text-gray-500"><span class="font-semibold text-[#2E5090]">Klik untuk upload</span></p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP (maks 3MB)</p>
                        </div>
                        <input id="thumbnail" type="file" name="thumbnail" class="hidden" accept="image/*" onchange="previewThumb(event)">
                    </label>
                </div>
                <div id="thumbPreview" class="mt-3 hidden rounded-xl overflow-hidden border shadow-sm">
                    <img id="thumbImg" src="#" alt="Preview" class="w-full h-auto max-h-48 object-cover">
                </div>
                @error('thumbnail')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="w-full bg-[#2E5090] text-white hover:bg-[#1f3661] px-4 py-3 rounded-xl text-sm font-medium transition-colors shadow-sm">
                Simpan Proker
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#konten',
        height: 480,
        menubar: false,
        plugins: ['advlist','autolink','lists','link','image','charmap','preview','anchor','searchreplace','visualblocks','code','fullscreen','insertdatetime','media','table','help','wordcount'],
        toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:16px }'
    });

    function previewThumb(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('thumbImg').src = reader.result;
            document.getElementById('thumbPreview').classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function previewMultiple(event) {
        const grid = document.getElementById('previewGrid');
        grid.innerHTML = '';
        Array.from(event.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative rounded-lg overflow-hidden border border-gray-200 aspect-square bg-gray-100';
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                grid.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function pelaksanaForm() {
        return {
            rows: [{ nama: '{{ old('pelaksana.0.nama', '') }}', nim: '{{ old('pelaksana.0.nim', '') }}', universitas: '{{ old('pelaksana.0.universitas', 'Universitas Riau') }}' }],
            add() { this.rows.push({ nama: '', nim: '', universitas: 'Universitas Riau' }); },
            remove(i) { if (this.rows.length > 1) this.rows.splice(i, 1); }
        };
    }
</script>
@endpush
