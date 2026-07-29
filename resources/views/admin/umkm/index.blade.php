@extends('layouts.admin')

@section('title', 'UMKM & Produk Desa')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">UMKM & Produk Desa</h2>
    <a href="{{ route('admin.umkm.create') }}" class="bg-[#2E5090] hover:bg-[#1f3661] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
        <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Produk
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 w-16">No</th>
                    <th class="px-6 py-3 w-24">Foto</th>
                    <th class="px-6 py-3">Nama Produk</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Penjual & Kontak</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($umkm as $index => $item)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">{{ $umkm->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="w-16 h-16 rounded-lg bg-gray-100 overflow-hidden border">
                            @if($item->foto)
                                <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama_produk }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $item->nama_produk }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $item->kategori }}</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-[#2E5090]">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $item->nama_penjual }}</div>
                        <div class="flex items-center text-xs text-green-600 mt-1">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12c0 2.115.545 4.103 1.51 5.86L.2 23.8l6.09-1.597C8.01 23.332 9.957 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm6.55 17.556c-.27.76-1.545 1.48-2.128 1.545-.583.065-1.344.204-4.28-1.01-3.535-1.464-5.836-5.074-6.012-5.308-.176-.234-1.437-1.91-1.437-3.643 0-1.733.905-2.587 1.226-2.935.32-.35.698-.436.932-.436.234 0 .468.006.67.014.21.008.497-.08.777.59.294.704.996 2.433 1.082 2.61.086.176.143.38.028.613-.114.234-.172.38-.344.584-.173.204-.363.45-.516.593-.173.16-.356.335-.152.686.204.35 .906 1.498 1.954 2.432 1.346 1.198 2.463 1.564 2.82 1.74.355.176.564.146.776-.1.213-.244.92-1.066 1.165-1.433.245-.367.49-.307.817-.183.327.12 2.062.973 2.417 1.15.356.177.593.265.68.414.086.15.086.865-.183 1.625z"/></svg>
                            {{ $item->no_whatsapp }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->is_active)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-200">Aktif</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-200">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.umkm.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 inline-flex" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.umkm.destroy', $item->id) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus produk UMKM ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 inline-flex" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada data UMKM ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($umkm->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-white">
        {{ $umkm->links() }}
    </div>
    @endif
</div>
@endsection
