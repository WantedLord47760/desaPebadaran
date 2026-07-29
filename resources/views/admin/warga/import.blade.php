@extends('layouts.admin')

@section('title', 'Import Warga')

@section('content')
<div class="mb-6 flex items-center">
    <a href="{{ route('admin.warga.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Import Data Warga</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Upload File Excel/CSV</h3>
        
        <form action="{{ route('admin.warga.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File (.xlsx, .csv)</label>
                <input type="file" name="file" accept=".xlsx,.csv" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-[#2E5090]
                    hover:file:bg-blue-100 border border-gray-300 rounded-lg p-2" required>
                @error('file')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            
            <button type="submit" class="w-full bg-[#2E5090] text-white hover:bg-[#1f3661] px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Proses Import
            </button>
        </form>
    </div>

    <div class="bg-blue-50 rounded-xl shadow-sm border border-blue-100 p-6 flex flex-col justify-between">
        <div>
            <h3 class="text-lg font-semibold text-blue-900 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Panduan & Template Import
            </h3>
            <div class="text-sm text-blue-800 space-y-2 mb-6">
                <p>Silakan unduh template format file Excel di bawah ini yang sudah dilengkapi dengan contoh <b>data dummy</b> siap pakai:</p>
                <ul class="list-disc list-inside space-y-1 ml-2">
                    <li>Header baris pertama berisi nama kolom.</li>
                    <li>Kolom utama: <b>nik</b>, <b>nama</b>, <b>no_kk</b> (Wajib diisi).</li>
                    <li>Kolom pendukung: <b>tempat_lahir</b>, <b>tanggal_lahir</b> (Format: YYYY-MM-DD), <b>jenis_kelamin</b> (L/P), <b>agama</b>, <b>pendidikan</b>, <b>pekerjaan</b>, <b>golongan_darah</b>, <b>status_perkawinan</b>, <b>shdk</b>, <b>kewarganegaraan</b>.</li>
                    <li>Jika <b>no_kk</b> belum ada di database, sistem secara otomatis akan membuatkan data Kartu Keluarga baru.</li>
                </ul>
            </div>
        </div>

        <div>
            <a href="{{ route('admin.warga.download-template') }}" class="inline-flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-lg text-sm font-semibold transition-colors shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Unduh Template Excel (.xlsx) + Data Dummy
            </a>
        </div>
    </div>
</div>
@endsection
