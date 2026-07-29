@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="mb-6 flex items-center">
    <a href="{{ route('admin.berita.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Edit Berita</h2>
</div>

<form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                    @error('judul')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konten Berita <span class="text-red-500">*</span></label>
                    <textarea name="konten" id="konten" class="w-full rounded-lg border-gray-300 shadow-sm">{{ old('konten', $berita->konten) }}</textarea>
                    @error('konten')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 pb-2 border-b">Pengaturan Publikasi</h3>
                
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $berita->is_published) ? 'checked' : '' }} class="rounded border-gray-300 text-[#2E5090] shadow-sm focus:border-[#2E5090] focus:ring focus:ring-[#2E5090] focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Publikasikan Langsung</span>
                    </label>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090]" required>
                        @foreach(['Berita', 'Pengumuman', 'Kegiatan'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori', $berita->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 pb-2 border-b">Thumbnail</h3>
                
                <div class="mb-4">
                    @if($berita->thumbnail)
                    <div class="mb-3 rounded overflow-hidden border">
                        <img src="{{ Storage::url($berita->thumbnail) }}" alt="Thumbnail saat ini" class="w-full h-auto">
                        <p class="text-xs text-center p-1 bg-gray-50 text-gray-500">Thumbnail saat ini</p>
                    </div>
                    @endif

                    <div class="flex items-center justify-center w-full">
                        <label for="thumbnail" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-6 h-6 mb-2 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="text-xs text-gray-500">Upload file baru untuk mengganti</p>
                            </div>
                            <input id="thumbnail" type="file" name="thumbnail" class="hidden" accept="image/*" onchange="previewImage(event)"/>
                        </label>
                    </div>
                    <div id="imagePreview" class="mt-4 hidden w-full rounded overflow-hidden shadow-sm">
                        <img id="preview" src="#" alt="Preview" class="w-full h-auto">
                    </div>
                    @error('thumbnail')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <button type="submit" class="w-full bg-[#2E5090] text-white hover:bg-[#1f3661] px-4 py-3 rounded-xl text-sm font-medium transition-colors shadow-sm">
                Perbarui Berita
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
        height: 500,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
        content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:16px }'
    });

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
