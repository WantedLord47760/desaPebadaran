@extends('layouts.admin')
@section('title', 'KUKERTA - Program Kerja Mahasiswa')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">KUKERTA — Program Kerja</h2>
    <a href="{{ route('admin.kukerta.create') }}" class="bg-[#2E5090] hover:bg-[#1f3661] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5 shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Tambah Proker
    </a>
</div>

{{-- Search Form --}}
<form method="GET" class="mb-4 flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau nama mahasiswa..." class="flex-1 rounded-lg border-gray-300 shadow-sm text-sm focus:border-[#2E5090] focus:ring-[#2E5090]">
    <button type="submit" class="bg-[#2E5090] text-white px-4 py-2 rounded-lg text-sm font-medium">Cari</button>
    @if(request('search'))
        <a href="{{ route('admin.kukerta.index') }}" class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-100">Reset</a>
    @endif
</form>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 w-12">No</th>
                    <th class="px-6 py-3 w-20">Foto</th>
                    <th class="px-6 py-3">Judul Proker</th>
                    <th class="px-6 py-3">Mahasiswa</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Publik</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kukerta as $index => $item)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">{{ $kukerta->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="w-16 h-12 rounded bg-gray-100 overflow-hidden border">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 max-w-xs">
                        <span class="line-clamp-2">{{ $item->judul }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div>{{ $item->nama_mahasiswa }}</div>
                        @if($item->nim) <div class="text-xs text-gray-400">{{ $item->nim }}</div> @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2.5 py-1 rounded border border-gray-200">{{ $item->kategori }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->status === 'Selesai')
                            <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded border border-emerald-200">Selesai</span>
                        @elseif($item->status === 'Berjalan')
                            <span class="bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded border border-amber-200">Berjalan</span>
                        @else
                            <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-200">Perencanaan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($item->is_published)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-200">Publik</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-200">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                        @if(!$item->is_published)
                        <form method="POST" action="{{ route('admin.kukerta.publish', $item->id) }}" class="inline-block" onsubmit="return confirm('Publikasikan proker ini?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-green-600 hover:text-green-900 inline-flex" title="Publish">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('admin.kukerta.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 inline-flex" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.kukerta.destroy', $item->id) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus proker ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 inline-flex" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-10 text-center text-gray-500">Belum ada data program kerja.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kukerta->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">{{ $kukerta->links() }}</div>
    @endif
</div>
@endsection
