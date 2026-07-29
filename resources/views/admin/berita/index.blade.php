@extends('layouts.admin')

@section('title', 'Berita & Artikel')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Berita & Artikel</h2>
    <a href="{{ route('admin.berita.create') }}" class="bg-[#2E5090] hover:bg-[#1f3661] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
        <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tulis Berita
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 w-16">No</th>
                    <th class="px-6 py-3 w-24">Thumbnail</th>
                    <th class="px-6 py-3">Judul Berita</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($berita as $index => $item)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">{{ $berita->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="w-16 h-12 rounded bg-gray-100 overflow-hidden border">
                            @if($item->thumbnail)
                                <img src="{{ Storage::url($item->thumbnail) }}" alt="Thumbnail" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->judul }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-200">{{ $item->kategori }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->is_published)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-200">Published</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-200">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $item->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        @if(!$item->is_published)
                        <form method="POST" action="{{ route('admin.berita.publish', $item->id) }}" class="inline-block" onsubmit="return confirm('Yakin ingin mempublikasikan berita ini?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-green-600 hover:text-green-900 inline-flex mr-1" title="Publish">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('admin.berita.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 inline-flex" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.berita.destroy', $item->id) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 inline-flex" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada data berita ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($berita->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-white">
        {{ $berita->links() }}
    </div>
    @endif
</div>
@endsection
