@extends('layouts.public')
@section('title', 'Beranda - Desa Pebadaran')

@section('content')
<!-- Hero Section -->
<section class="relative pt-24 pb-32 lg:pt-36 lg:pb-48 bg-navy-900 overflow-hidden">
    <!-- Efek Cahaya / Glow -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-full bg-gradient-to-b from-white/10 to-transparent pointer-events-none"></div>
    <div class="absolute top-1/4 right-0 w-[500px] h-[500px] bg-white rounded-full blur-[150px] opacity-5 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-royal rounded-full blur-[120px] opacity-15 pointer-events-none"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="max-w-4xl mx-auto" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
            
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-heading font-extrabold text-white mb-6 drop-shadow-lg leading-tight transition-all duration-1000 delay-100 transform" :class="shown ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                Selamat Datang di <br/>
                <span class="text-white/90">Kampung Pebadaran</span>
            </h1>
            
            <p class="text-lg md:text-2xl text-gray-200 font-light mb-10 max-w-2xl mx-auto drop-shadow transition-all duration-1000 delay-300 transform" :class="shown ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                Bersama Membangun Desa yang Maju, Sejahtera, dan Berbudaya Melayu.
            </p>
            
            <div class="transition-all duration-1000 delay-500 transform" :class="shown ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                <a href="#explore" class="inline-flex items-center justify-center px-8 py-4 bg-white hover:bg-gray-100 text-navy-900 font-bold rounded-full transition-all hover:scale-105 shadow-[0_10px_25px_rgba(255,255,255,0.2)]">
                    Jelajahi Desa
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- Quick Access Menu -->
<section id="explore" class="relative -mt-16 z-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        @php
            $menus = [
                ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'label' => 'Profil Desa', 'route' => 'public.profil'],
                ['icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'label' => 'Berita', 'route' => 'public.berita.index'],
                ['icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'label' => 'UMKM', 'route' => 'public.umkm.index'],
                ['icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Galeri', 'route' => 'public.galeri'],
            ];
        @endphp
        
        @foreach($menus as $index => $menu)
        <a href="{{ route($menu['route']) }}" 
           class="glass rounded-xl p-6 flex flex-col items-center justify-center text-center hover-card-effect group border border-white/10"
           x-data="{ shown: false }" x-intersect="setTimeout(() => shown = true, {{ $index * 100 }})" :class="shown ? 'animate-fade-in-up' : 'opacity-0'">
            <div class="w-16 h-16 rounded-full bg-gold/20 flex items-center justify-center mb-4 group-hover:bg-gold transition-colors">
                <svg class="w-8 h-8 text-gold group-hover:text-navy-900 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}" />
                </svg>
            </div>
            <h3 class="font-heading font-semibold text-white text-lg group-hover:text-gold-light">{{ $menu['label'] }}</h3>
        </a>
        @endforeach
    </div>
</section>

<!-- Statistics Section -->
<section class="py-20 bg-cream relative">
    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-navy-700 to-transparent opacity-30"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" x-data="{ shown: false }" x-intersect="shown = true" :class="shown ? 'animate-fade-in-up' : 'opacity-0'">
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-navy-900 mb-4">Statistik Desa</h2>
            <div class="w-24 h-1 bg-navy-900 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-10">
            @php
                $stats = [
                    ['label' => 'Total Penduduk', 'value' => $totalPenduduk ?? '1,240', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ['label' => 'Jumlah KK', 'value' => $totalKK ?? '342', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['label' => 'Laki-laki', 'value' => $totalLaki ?? '630', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ['label' => 'Perempuan', 'value' => $totalPerempuan ?? '610', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ];
            @endphp
            
            @foreach($stats as $index => $stat)
            <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover-card-effect border-b-4 border-navy-900"
                 x-data="{ shown: false }" x-intersect="setTimeout(() => shown = true, {{ $index * 150 }})" :class="shown ? 'animate-fade-in-up' : 'opacity-0'">
                <div class="w-14 h-14 mx-auto bg-navy-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-royal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}" />
                    </svg>
                </div>
                <div class="text-3xl font-heading font-bold text-navy-900 mb-2">{{ $stat['value'] }}</div>
                <div class="text-sm font-medium text-navy-700 uppercase tracking-wide">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Latest News -->
<section class="py-20 bg-white relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12" x-data="{ shown: false }" x-intersect="shown = true" :class="shown ? 'animate-fade-in-up' : 'opacity-0'">
            <div>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-navy-900 mb-4">Berita Terkini</h2>
                <div class="w-24 h-1 bg-navy-900 rounded-full"></div>
            </div>
            <a href="{{ route('public.berita.index') }}" class="hidden md:flex items-center text-royal hover:text-royal-light font-medium group">
                Lihat Semua 
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @if(isset($latestBerita) && $latestBerita->count() > 0)
                @foreach($latestBerita as $index => $berita)
                <article class="bg-cream rounded-2xl overflow-hidden shadow-md hover-card-effect group flex flex-col h-full relative"
                         x-data="{ shown: false }" x-intersect="setTimeout(() => shown = true, {{ $index * 150 }})" :class="shown ? 'animate-fade-in-up' : 'opacity-0'">
                    <a href="{{ route('public.berita.show', $berita->slug) }}" class="absolute inset-0 z-10"></a>
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4 bg-navy-900 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                            {{ $berita->kategori->nama ?? 'Info' }}
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="text-xs text-navy-700/70 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}
                        </div>
                        <h3 class="text-xl font-heading font-bold text-navy-900 mb-3 line-clamp-2 group-hover:text-royal transition-colors relative z-20">
                            <a href="{{ route('public.berita.show', $berita->slug) }}">{{ $berita->judul }}</a>
                        </h3>
                        <p class="text-navy-800/80 text-sm mb-6 line-clamp-3 flex-grow relative z-20">{{ Str::limit(strip_tags($berita->konten), 120) }}</p>
                        <a href="{{ route('public.berita.show', $berita->slug) }}" class="inline-flex items-center text-sm font-semibold text-royal group-hover:text-royal-light mt-auto relative z-20">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </article>
                @endforeach
            @else
                <div class="col-span-3 text-center py-12 text-navy-700/50">Belum ada berita.</div>
            @endif
        </div>
        
        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('public.berita.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-royal text-royal rounded-full font-medium hover:bg-royal hover:text-white transition-colors">
                Lihat Semua Berita
            </a>
        </div>
    </div>
</section>

<!-- UMKM Highlights -->
<section class="py-20 bg-navy-900 text-white relative overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12" x-data="{ shown: false }" x-intersect="shown = true" :class="shown ? 'animate-fade-in-up' : 'opacity-0'">
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-white mb-4">Produk UMKM Unggulan</h2>
            <div class="w-24 h-1 bg-white/30 mx-auto rounded-full mb-6"></div>
            <p class="text-cream/80 max-w-2xl mx-auto">Dukung ekonomi kreatif masyarakat Desa Pebadaran dengan membeli produk lokal berkualitas.</p>
        </div>

        <div class="flex overflow-x-auto pb-8 -mx-4 px-4 sm:mx-0 sm:px-0 space-x-6 snap-x hide-scrollbar">
            @if(isset($featuredUmkm) && $featuredUmkm->count() > 0)
                @foreach($featuredUmkm as $umkm)
                <div class="flex-none w-72 sm:w-80 snap-center bg-navy-800 rounded-2xl overflow-hidden shadow-xl border border-white/10 group hover:-translate-y-2 transition-transform duration-300">
                    <div class="h-48 relative overflow-hidden">
                        <img src="{{ asset('storage/' . $umkm->foto) }}" alt="{{ $umkm->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-800 to-transparent opacity-80"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <span class="bg-white/90 backdrop-blur text-navy-900 text-xs font-bold px-2 py-1 rounded shadow-sm">
                                Rp {{ number_format($umkm->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-heading font-bold mb-1 truncate">{{ $umkm->nama_produk }}</h3>
                        <p class="text-sm text-cream/60 flex items-center mb-4">
                            <svg class="w-4 h-4 mr-1 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $umkm->nama_penjual }}
                        </p>
                        <a href="{{ route('public.umkm.show', $umkm->id) }}" class="block w-full text-center py-2.5 bg-white/5 hover:bg-royal text-white rounded-lg transition-colors text-sm font-medium border border-white/10">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <div class="w-full text-center py-12 text-cream/50">Data UMKM belum tersedia.</div>
            @endif
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('public.umkm.index') }}" class="inline-flex items-center px-8 py-3 bg-white hover:bg-gray-100 text-navy-900 rounded-full font-bold transition-colors">
                Jelajahi Semua Produk
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<style>
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
@endpush
