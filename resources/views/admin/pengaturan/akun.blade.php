@extends('layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Keamanan Akun Admin</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-xl">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Ganti Password</h3>
    
    <form action="{{ route('admin.pengaturan.akun.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini <span class="text-red-500">*</span></label>
                <input type="password" name="current_password" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]" required>
                @error('current_password')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-red-500">*</span></label>
                <input type="password" name="password" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]" required minlength="8">
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter.</p>
                @error('password')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]" required>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-[#2E5090] text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-[#1f3661] transition-colors shadow-sm">Update Password</button>
        </div>
    </form>
</div>
@endsection
