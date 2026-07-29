@extends('layouts.admin')

@section('title', 'Data Warga')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <h2 class="text-2xl font-bold text-gray-800">Data Warga</h2>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.warga.download-template') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center" title="Unduh Template Excel untuk Import">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Template Import
        </a>
        <a href="{{ route('admin.warga.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export CSV
        </a>
        <a href="{{ route('admin.warga.import') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Import
        </a>
        <a href="{{ route('admin.warga.create') }}" class="bg-[#2E5090] hover:bg-[#1f3661] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Warga
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-4 border-b border-gray-100 bg-gray-50/50">
        <form action="{{ route('admin.warga.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIK atau Nama..." class="w-full border-gray-300 rounded-lg focus:ring-[#2E5090] focus:border-[#2E5090] text-sm py-2">
            </div>
            <div class="sm:w-48">
                <select name="jenis_kelamin" class="w-full border-gray-300 rounded-lg focus:ring-[#2E5090] focus:border-[#2E5090] text-sm py-2" onchange="this.form.submit()">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                    <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                </select>
            </div>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Filter
            </button>
            @if(request()->has('search') || request()->has('jenis_kelamin'))
            <a href="{{ route('admin.warga.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                Reset
            </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">NIK</th>
                    <th class="px-6 py-3">Nama Lengkap</th>
                    <th class="px-6 py-3">L/P</th>
                    <th class="px-6 py-3">Umur</th>
                    <th class="px-6 py-3">Pekerjaan</th>
                    <th class="px-6 py-3">No KK</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($warga as $index => $item)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">{{ $warga->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->nik }}</td>
                    <td class="px-6 py-4">{{ $item->nama }}</td>
                    <td class="px-6 py-4">{{ $item->jenis_kelamin }}</td>
                    <td class="px-6 py-4">{{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->age . ' thn' : '-' }}</td>
                    <td class="px-6 py-4">{{ $item->pekerjaan }}</td>
                    <td class="px-6 py-4">
                        @if($item->keluarga)
                        <a href="{{ route('admin.keluarga.show', $item->keluarga->id) }}" class="text-[#2E5090] hover:underline">{{ $item->keluarga->no_kk }}</a>
                        @else
                        -
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.warga.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 inline-flex" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <button type="button" x-data="" @click="$dispatch('open-modal', 'confirm-user-deletion-{{ $item->id }}')" class="text-red-600 hover:text-red-900 inline-flex" title="Hapus">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>

                        <!-- Delete Modal -->
                        <div x-data="{ show: false }" x-show="show" @open-modal.window="if ($event.detail === 'confirm-user-deletion-{{ $item->id }}') show = true" @close.window="show = false" @keydown.escape.window="show = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div x-show="show" class="fixed inset-0 transition-opacity" aria-hidden="true" @click="show = false"><div class="absolute inset-0 bg-gray-500 opacity-75"></div></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div x-show="show" class="relative z-10 inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Data Warga</h3>
                                                <div class="mt-2"><p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data <b>{{ $item->nama }}</b>? Tindakan ini tidak dapat dibatalkan.</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <form method="POST" action="{{ route('admin.warga.destroy', $item->id) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Hapus</button>
                                        </form>
                                        <button type="button" @click="show = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Tidak ada data warga ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($warga->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-white">
        {{ $warga->links() }}
    </div>
    @endif
</div>
@endsection
