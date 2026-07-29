@extends('layouts.admin')

@section('title', 'Detail Keluarga')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center">
        <a href="{{ route('admin.keluarga.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Detail Kartu Keluarga</h2>
    </div>
    <a href="{{ route('admin.keluarga.edit', $keluarga->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        Edit KK
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-fit">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">Informasi KK</h3>
        
        <div class="space-y-4 text-sm">
            <div>
                <p class="text-gray-500 mb-1">No. Kartu Keluarga</p>
                <p class="font-bold text-lg text-gray-900">{{ $keluarga->no_kk }}</p>
            </div>
            
            <div>
                <p class="text-gray-500 mb-1">Kepala Keluarga</p>
                <p class="font-medium text-gray-900">{{ $keluarga->kepala_keluarga }}</p>
            </div>
            
            <div>
                <p class="text-gray-500 mb-1">Alamat</p>
                <p class="text-gray-900">{{ $keluarga->alamat }}</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 mb-1">RT / RW</p>
                    <p class="text-gray-900">{{ $keluarga->rt ?? '-' }} / {{ $keluarga->rw ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Dusun</p>
                    <p class="text-gray-900">{{ $keluarga->dusun ?? '-' }}</p>
                </div>
            </div>
            
            <div class="pt-4 border-t mt-4">
                <p class="text-gray-500 mb-1">Jumlah Anggota Keluarga</p>
                <p class="font-bold text-xl text-[#2E5090]">{{ $keluarga->warga ? $keluarga->warga->count() : 0 }} Jiwa</p>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Anggota Keluarga</h3>
            <a href="{{ route('admin.warga.create', ['keluarga_id' => $keluarga->id]) }}" class="text-[#2E5090] hover:text-[#1f3661] text-sm font-medium flex items-center bg-blue-50 px-3 py-1.5 rounded">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Anggota
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">NIK</th>
                        <th class="px-4 py-2">Nama Lengkap</th>
                        <th class="px-4 py-2">L/P</th>
                        <th class="px-4 py-2">SHDK</th>
                        <th class="px-4 py-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keluarga->warga ?? [] as $anggota)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $anggota->nik }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $anggota->nama }}</td>
                        <td class="px-4 py-3">{{ $anggota->jenis_kelamin }}</td>
                        <td class="px-4 py-3">{{ $anggota->status_hubungan_dalam_keluarga ?? '-' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.warga.edit', $anggota->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                            Belum ada anggota keluarga.<br>
                            <a href="{{ route('admin.warga.create', ['keluarga_id' => $keluarga->id]) }}" class="text-[#2E5090] hover:underline mt-2 inline-block">Tambah Warga Sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
