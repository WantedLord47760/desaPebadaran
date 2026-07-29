@extends('layouts.public')
@section('title', 'KUKERTA - Program Kerja Mahasiswa KKN Desa Pebadaran')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative pt-24 pb-16 sm:pt-32 sm:pb-20 bg-gradient-to-b from-navy-900 via-navy-800 to-navy-900 overflow-hidden">
    {{-- Soft Ambient Glow --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-5xl h-full bg-royal/10 blur-[120px] pointer-events-none"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center sm:text-left">
        <div class="max-w-3xl mx-auto sm:mx-0" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
            {{-- Breadcrumb --}}
            <div class="flex items-center justify-center sm:justify-start space-x-2 text-xs sm:text-sm text-cream/60 mb-4 sm:mb-6 transition-all duration-700" :class="shown ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                <a href="{{ route('public.beranda') }}" class="hover:text-gold transition-colors">Beranda</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white">KUKERTA</span>
            </div>

            <div class="inline-flex items-center bg-gold/15 border border-gold/30 text-gold text-xs font-semibold px-3 py-1.5 rounded-full mb-4 transition-all duration-700 delay-100" :class="shown ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                <svg class="w-3.5 h-3.5 mr-1.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Kuliah Kerja Nyata
            </div>

            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-heading font-extrabold text-white mb-4 sm:mb-5 leading-tight transition-all duration-700 delay-150" :class="shown ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                Program Kerja <span class="text-gold">KUKERTA</span>
            </h1>
            <p class="text-base sm:text-lg text-cream/70 max-w-xl mx-auto sm:mx-0 transition-all duration-700 delay-200" :class="shown ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                Kumpulan hasil dan dokumentasi program kerja mahasiswa KKN yang telah berkontribusi untuk masyarakat Desa Pebadaran.
            </p>
        </div>
    </div>
</section>

{{-- ===== STATISTIK ===== --}}
<section class="relative z-20 -mt-6 sm:-mt-10 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
        @php
            $statItems = [
                ['label' => 'Total Proker', 'value' => $stats['total'], 'color' => 'bg-navy-900 text-white', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['label' => 'Selesai', 'value' => $stats['selesai'], 'color' => 'bg-emerald-600 text-white', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Berjalan', 'value' => $stats['berjalan'], 'color' => 'bg-amber-500 text-white', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
        @endphp
        @foreach($statItems as $s)
        <div class="bg-white rounded-2xl p-4 sm:p-5 flex items-center gap-4 shadow-xl border border-navy-900/10 hover:-translate-y-0.5 transition-transform">
            <div class="w-12 h-12 {{ $s['color'] }} rounded-xl flex items-center justify-center shrink-0 shadow-md">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"/></svg>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-heading font-extrabold text-navy-900">{{ $s['value'] }}</div>
                <div class="text-xs sm:text-sm font-medium text-navy-600/80">{{ $s['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ===== CONTENT SECTION ===== --}}
<section class="pt-8 pb-20 bg-cream min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        {{-- FILTER & SEARCH BAR --}}
        <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-sm border border-navy-900/10 mb-8 sm:mb-12">
            <form method="GET" action="{{ route('public.kukerta.index') }}" class="flex flex-col md:flex-row gap-3">
                
                {{-- Search Box --}}
                <div class="relative flex-1 flex items-center bg-gray-50 border border-gray-200 rounded-xl focus-within:border-royal focus-within:ring-2 focus-within:ring-royal/20 transition-all overflow-hidden">
                    <span class="pl-4 text-navy-400 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari judul atau nama pelaksana..."
                           class="w-full py-3 px-3 bg-transparent border-0 text-navy-900 placeholder-navy-400 focus:outline-none text-sm md:text-base">
                </div>

                {{-- Category Filter Dropdown --}}
                <div class="w-full md:w-56 shrink-0">
                    <select name="kategori" class="w-full py-3 px-4 bg-gray-50 border border-gray-200 rounded-xl text-navy-900 text-sm md:text-base focus:outline-none focus:border-royal focus:ring-2 focus:ring-royal/20 transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" @selected(request('kategori') === $cat)>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Submit & Reset Buttons --}}
                <div class="flex gap-2 w-full md:w-auto shrink-0">
                    <button type="submit" class="flex-1 md:flex-initial px-6 py-3 bg-navy-900 hover:bg-royal text-white font-semibold rounded-xl transition-colors shadow-sm text-sm md:text-base text-center">
                        Cari
                    </button>
                    @if(request('search') || request('kategori'))
                        <a href="{{ route('public.kukerta.index') }}" class="px-4 py-3 border border-gray-300 rounded-xl text-navy-700 hover:bg-gray-100 transition-colors text-center text-sm md:text-base">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- DAFTAR PROKER (CARDS GRID) --}}
        @if($projects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach($projects as $index => $project)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full border border-gray-200/80 relative hover:-translate-y-1"
                         x-data="{ shown: false }" x-intersect="setTimeout(() => shown = true, {{ ($index % 3) * 100 }})"
                         :class="shown ? 'animate-fade-in-up' : 'opacity-0'">

                    <a href="{{ route('public.kukerta.show', $project->slug) }}" class="absolute inset-0 z-10" aria-label="{{ $project->judul }}"></a>

                    {{-- Thumbnail --}}
                    <div class="relative h-48 sm:h-52 overflow-hidden bg-navy-900/5 shrink-0">
                        @if($project->thumbnail)
                            <img src="{{ asset('storage/' . $project->thumbnail) }}"
                                 alt="{{ $project->judul }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-navy-800 to-royal">
                                <svg class="w-16 h-16 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                        @endif

                        {{-- Badges --}}
                        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 max-w-[calc(100%-1.5rem)]">
                            <span class="bg-navy-900/85 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">{{ $project->kategori }}</span>
                        </div>
                        <div class="absolute top-3 right-3">
                            @if($project->status === 'Selesai')
                                <span class="bg-emerald-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">✓ Selesai</span>
                            @elseif($project->status === 'Berjalan')
                                <span class="bg-amber-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">⏳ Berjalan</span>
                            @else
                                <span class="bg-gray-600 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">📋 Perencanaan</span>
                            @endif
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-5 sm:p-6 flex flex-col flex-grow">
                        {{-- Pelaksana --}}
                        <div class="flex items-center gap-1.5 text-xs font-medium text-navy-600/80 mb-2.5">
                            <svg class="w-4 h-4 shrink-0 text-royal" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="line-clamp-1">{{ $project->pelaksana_names }}</span>
                        </div>

                        <h2 class="text-lg sm:text-xl font-heading font-bold text-navy-900 mb-2.5 line-clamp-2 group-hover:text-royal transition-colors relative z-20">
                            <a href="{{ route('public.kukerta.show', $project->slug) }}">{{ $project->judul }}</a>
                        </h2>

                        <p class="text-xs sm:text-sm text-navy-700/80 mb-4 line-clamp-3 flex-grow leading-relaxed">
                            {{ Str::limit(strip_tags($project->konten), 120) }}
                        </p>

                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                            @if($project->published_at)
                            <span class="text-xs text-navy-500/70 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $project->published_at->translatedFormat('d M Y') }}
                            </span>
                            @else
                            <span></span>
                            @endif
                            <span class="inline-flex items-center text-xs sm:text-sm font-semibold text-royal group-hover:text-royal-light relative z-20">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            @if($projects->hasPages())
            <div class="mt-12 flex justify-center">{{ $projects->links() }}</div>
            @endif

        @else
            <div class="bg-white rounded-2xl p-12 text-center border border-gray-200/80 shadow-sm max-w-xl mx-auto my-8">
                <div class="w-16 h-16 bg-navy-50 text-navy-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3 class="text-xl font-heading font-bold text-navy-900 mb-2">Belum ada data proker</h3>
                <p class="text-sm text-navy-600 mb-6">Coba ubah kata kunci atau kata pencarian Anda.</p>
                @if(request('search') || request('kategori'))
                    <a href="{{ route('public.kukerta.index') }}" class="inline-flex items-center px-5 py-2.5 bg-navy-900 text-white rounded-xl text-sm font-medium hover:bg-royal transition-colors">
                        Reset Filter
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>

@endsection
