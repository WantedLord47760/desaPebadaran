@extends('layouts.admin')

@section('title', 'Galeri Desa')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Galeri Desa</h2>
    <a href="{{ route('admin.galeri.create') }}" class="bg-[#2E5090] hover:bg-[#1f3661] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
        <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Media
    </a>
</div>

<div class="mb-6 flex gap-2">
    <a href="{{ route('admin.galeri.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg {{ !request('tipe') ? 'bg-[#2E5090] text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">Semua</a>
    <a href="{{ route('admin.galeri.index', ['tipe' => 'Foto']) }}" class="px-4 py-2 text-sm font-medium rounded-lg {{ request('tipe') == 'Foto' ? 'bg-[#2E5090] text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">Foto</a>
    <a href="{{ route('admin.galeri.index', ['tipe' => 'Video']) }}" class="px-4 py-2 text-sm font-medium rounded-lg {{ request('tipe') == 'Video' ? 'bg-[#2E5090] text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">Video</a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($galeri as $item)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">
        <div class="aspect-[4/3] relative bg-gray-100 overflow-hidden">
            @if($item->tipe == 'Foto')
                <img src="{{ Storage::url($item->file_path) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-800 text-white">
                    <svg class="w-12 h-12 opacity-80" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                </div>
            @endif
            
            <div class="absolute top-2 right-2">
                <span class="bg-black/60 text-white text-xs px-2 py-1 rounded backdrop-blur-sm">{{ $item->tipe }}</span>
            </div>
            
            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                <form method="POST" action="{{ route('admin.galeri.destroy', $item->id) }}" onsubmit="return confirm('Hapus item ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        <div class="p-4">
            <h3 class="font-medium text-gray-900 truncate" title="{{ $item->judul }}">{{ $item->judul }}</h3>
            @if($item->deskripsi)
                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item->deskripsi }}</p>
            @endif
        </div>
    </div>
    @empty
    <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <p>Belum ada media di galeri.</p>
    </div>
    @endforelse
</div>

@if($galeri->hasPages())
<div class="mt-6">
    {{ $galeri->links() }}
</div>
@endif
@endsection
