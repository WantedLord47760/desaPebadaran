<aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed inset-y-0 left-0 z-30 w-64 bg-[#0F1B33] text-gray-300 transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col h-screen overflow-y-auto">
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-center h-16 bg-[#0B1426] border-b border-gray-800 shrink-0 px-4">
        <div class="flex items-center gap-3">
            @php $logo = \App\Models\ProfilDesa::where('key', 'logo')->value('value'); @endphp
            @if($logo)
                <img src="{{ Storage::url($logo) }}" alt="Logo" class="w-8 h-8 object-contain">
            @else
                <div class="w-8 h-8 rounded bg-white flex items-center justify-center text-[#0F1D3A] font-bold">
                    DP
                </div>
            @endif
            <span class="text-white text-lg font-bold tracking-wider">{{ \App\Models\ProfilDesa::where('key', 'nama_desa')->value('value') ?? 'Desa Pebadaran' }}</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-6">
        
        <!-- Dashboard -->
        <div>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
        </div>

        <!-- KEPENDUDUKAN -->
        <div>
            <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Kependudukan</h3>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.keluarga.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.keluarga.*') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Data Keluarga
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.warga.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.warga.*') && !request()->routeIs('admin.warga.import') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Data Warga
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.warga.import') }}" class="flex items-center px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.warga.import') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Import Warga
                    </a>
                </li>
            </ul>
        </div>

        <!-- KONTEN -->
        <div>
            <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Konten</h3>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.berita.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.berita.*') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        Berita
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.umkm.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.umkm.*') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        UMKM & Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.galeri.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.galeri.*') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Galeri
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.kukerta.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.kukerta.*') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        KUKERTA
                    </a>
                </li>
            </ul>
        </div>



        <!-- PENGATURAN -->
        <div>
            <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pengaturan</h3>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.pengaturan.profil') }}" class="flex items-center px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.pengaturan.profil') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Profil Desa
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pengaturan.visi-misi') }}" class="flex items-center px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.pengaturan.visi-misi') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Visi & Misi
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pengaturan.struktur') }}" class="flex items-center px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.pengaturan.struktur') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Struktur Organisasi
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.pengaturan.akun') }}" class="flex items-center px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.pengaturan.akun') ? 'bg-[#2E5090] text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Akun Admin
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>
