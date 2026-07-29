@extends('layouts.admin')
@section('title', 'Edit Proker KUKERTA')

@section('content')
<div class="mb-6 flex items-center">
    <a href="{{ route('admin.kukerta.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Edit Proker KUKERTA</h2>
</div>

<form action="{{ route('admin.kukerta.update', $kukertum->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Kolom Kiri: Konten ── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Judul & Konten --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Program Kerja <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $kukertum->judul) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                    @error('judul')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi / Isi Laporan <span class="text-red-500">*</span></label>
                    <textarea name="konten" id="konten" class="w-full rounded-lg border-gray-300 shadow-sm">{{ old('konten', $kukertum->konten) }}</textarea>
                    @error('konten')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Pelaksana (Multi-row) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6"
                 x-data="pelaksanaForm({{ json_encode(old('pelaksana', $kukertum->pelaksana ?? [['nama'=>'','nim'=>'','universitas'=>'Universitas Riau']])) }})">
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
            </div>

            {{-- Foto Dokumentasi yang sudah ada --}}
            @if($kukertum->foto_dokumentasi && count($kukertum->foto_dokumentasi) > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 pb-3 border-b">Foto Dokumentasi Saat Ini</h3>
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3" id="existingFotos">
                    @foreach($kukertum->foto_dokumentasi as $path)
                    <div class="relative group rounded-lg overflow-hidden border border-gray-200 aspect-square bg-gray-100" id="foto-{{ md5($path) }}">
                        <img src="{{ asset('storage/' . $path) }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <button type="button" onclick="markRemove('{{ $path }}', '{{ md5($path) }}')"
                                    class="bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div id="removeFotoInputs"></div>
                <p class="text-xs text-gray-400 mt-2">Hover foto lalu klik ikon hapus untuk menghapus foto tertentu.</p>
            </div>
            @endif

            {{-- Upload Foto Baru --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 pb-3 border-b">
                    Tambah Foto Dokumentasi Baru <span class="text-gray-400 font-normal text-xs">(opsional, bisa pilih beberapa)</span>
                </h3>
                <div class="flex items-center justify-center w-full mb-4">
                    <label for="foto_dokumentasi" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <svg class="w-7 h-7 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-xs text-gray-500"><span class="font-semibold text-[#2E5090]">Upload foto baru</span> – PNG, JPG, WEBP maks 3MB</p>
                        <input id="foto_dokumentasi" type="file" name="foto_dokumentasi[]" class="hidden" accept="image/*" multiple onchange="previewMultiple(event)">
                    </label>
                </div>
                <div id="previewGrid" class="grid grid-cols-3 sm:grid-cols-4 gap-3"></div>
            </div>
        </div>

        {{-- ── Kolom Kanan: Sidebar ── --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Pengaturan --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 pb-2 border-b">Pengaturan Publikasi</h3>

                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $kukertum->is_published) ? 'checked' : '' }} class="rounded border-gray-300 text-[#2E5090] shadow-sm focus:ring-[#2E5090]">
                        <span class="text-sm text-gray-700">Publikasikan</span>
                    </label>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" @selected(old('kategori', $kukertum->kategori) === $cat)>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
                        @foreach(['Perencanaan', 'Berjalan', 'Selesai'] as $s)
                            <option value="{{ $s }}" @selected(old('status', $kukertum->status) === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $kukertum->tanggal_mulai?->format('Y-m-d')) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $kukertum->tanggal_selesai?->format('Y-m-d')) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
                </div>
            </div>

            {{-- Thumbnail --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 pb-2 border-b">Thumbnail / Foto Cover</h3>

                @if($kukertum->thumbnail)
                <div class="mb-3 rounded-xl overflow-hidden border shadow-sm">
                    <img src="{{ asset('storage/' . $kukertum->thumbnail) }}" alt="Thumbnail saat ini" class="w-full h-auto">
                    <p class="text-xs text-center p-1 bg-gray-50 text-gray-500">Thumbnail saat ini</p>
                </div>
                @endif

                <div class="flex items-center justify-center w-full">
                    <label for="thumbnail" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6 mb-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg>
                        <p class="text-xs text-gray-500">Upload file baru untuk mengganti</p>
                        <input id="thumbnail" type="file" name="thumbnail" class="hidden" accept="image/*" onchange="previewThumb(event)">
                    </label>
                </div>
                <div id="thumbPreview" class="mt-3 hidden rounded-xl overflow-hidden border shadow-sm">
                    <img id="thumbImg" src="#" alt="Preview" class="w-full h-auto max-h-48 object-cover">
                </div>
                @error('thumbnail')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="w-full bg-[#2E5090] text-white hover:bg-[#1f3661] px-4 py-3 rounded-xl text-sm font-medium transition-colors shadow-sm">
                Simpan Perubahan
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

    function markRemove(path, hash) {
        const card = document.getElementById('foto-' + hash);
        if (card) card.style.opacity = '0.3';
        const container = document.getElementById('removeFotoInputs');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_foto[]';
        input.value = path;
        container.appendChild(input);
    }

    function pelaksanaForm(initial) {
        return {
            rows: initial && initial.length > 0 ? initial : [{ nama: '', nim: '', universitas: 'Universitas Riau' }],
            add() { this.rows.push({ nama: '', nim: '', universitas: 'Universitas Riau' }); },
            remove(i) { if (this.rows.length > 1) this.rows.splice(i, 1); }
        };
    }
</script>
@endpush
