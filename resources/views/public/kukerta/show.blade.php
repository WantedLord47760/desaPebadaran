@extends('layouts.public')
@section('title', $project->judul . ' - KUKERTA Desa Pebadaran')

@section('content')
<article class="bg-cream min-h-screen pb-20">

    {{-- ===== HERO ===== --}}
    <header class="relative pt-20 sm:pt-24">
        <div class="absolute top-0 inset-x-0 h-56 sm:h-72 bg-navy-900 rounded-b-[2rem] sm:rounded-b-[3rem]"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-4xl pt-4 sm:pt-8">
            {{-- Breadcrumb --}}
            <div class="flex items-center space-x-2 text-xs sm:text-sm text-cream/70 mb-4 overflow-x-auto whitespace-nowrap py-1">
                <a href="{{ route('public.beranda') }}" class="hover:text-gold transition-colors shrink-0">Beranda</a>
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('public.kukerta.index') }}" class="hover:text-gold transition-colors shrink-0">KUKERTA</a>
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white/90 truncate max-w-[150px] sm:max-w-xs">{{ $project->judul }}</span>
            </div>

            {{-- Main Featured Card Image --}}
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden p-1.5 sm:p-2.5 border border-navy-900/10">
                <div class="relative w-full rounded-xl sm:rounded-2xl overflow-hidden bg-navy-950 flex items-center justify-center min-h-[250px] max-h-[550px]">
                    @if($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}"
                             alt="{{ $project->judul }}"
                             class="w-full h-auto max-h-[550px] object-contain mx-auto block">
                    @else
                        <div class="w-full h-64 sm:h-80 bg-gradient-to-br from-navy-800 to-royal flex items-center justify-center">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    {{-- ===== KONTEN ===== --}}
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl mt-6 sm:mt-10">

        {{-- Meta & Title Info --}}
        <div class="mb-8 text-center">
            {{-- Kategori & Status Badges (Dibawah Foto) --}}
            <div class="flex flex-wrap items-center justify-center gap-2.5 mb-4">
                <span class="bg-navy-900 text-white text-xs sm:text-sm font-bold px-4 py-1.5 rounded-lg shadow-sm">
                    📁 {{ $project->kategori }}
                </span>
                @if($project->status === 'Selesai')
                    <span class="bg-emerald-600 text-white text-xs sm:text-sm font-bold px-4 py-1.5 rounded-lg shadow-sm">✓ Selesai</span>
                @elseif($project->status === 'Berjalan')
                    <span class="bg-amber-500 text-white text-xs sm:text-sm font-bold px-4 py-1.5 rounded-lg shadow-sm">⏳ Berjalan</span>
                @else
                    <span class="bg-gray-600 text-white text-xs sm:text-sm font-bold px-4 py-1.5 rounded-lg shadow-sm">📋 Perencanaan</span>
                @endif
            </div>

            {{-- Judul Berita --}}
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-heading font-extrabold text-navy-900 leading-tight mb-5">
                {{ $project->judul }}
            </h1>

            {{-- Detail Meta Bar (Tanggal & Jadwal) --}}
            <div class="flex flex-wrap items-center justify-center gap-3 text-xs sm:text-sm text-navy-800">
                @if($project->published_at)
                <div class="inline-flex items-center bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-xs gap-2">
                    <svg class="w-4 h-4 text-royal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="font-medium text-navy-900">Diterbitkan: {{ $project->published_at->translatedFormat('d F Y') }}</span>
                </div>
                @endif

                @if($project->tanggal_mulai || $project->tanggal_selesai)
                <div class="inline-flex items-center bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-xs gap-2">
                    <svg class="w-4 h-4 text-royal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-medium text-navy-900">
                        Jadwal Pelaksanaan:
                        @if($project->tanggal_mulai) {{ $project->tanggal_mulai->translatedFormat('d M Y') }} @endif
                        @if($project->tanggal_selesai) – {{ $project->tanggal_selesai->translatedFormat('d M Y') }} @endif
                    </span>
                </div>
                @endif
            </div>

            <div class="w-20 sm:w-24 h-1 bg-navy-900 mx-auto rounded-full mt-6"></div>
        </div>

        {{-- Daftar Tim Pelaksana --}}
        @if(count($project->pelaksana ?? []) > 0)
        <div class="mb-8 bg-white rounded-2xl shadow-sm border border-navy-100 p-5 sm:p-6">
            <h2 class="text-base sm:text-lg font-heading font-bold text-navy-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-royal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Tim Pelaksana
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3.5">
                @foreach($project->pelaksana as $p)
                <div class="flex items-center gap-3 p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-navy-900/10 text-royal flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-navy-900 text-sm leading-snug break-words">{{ $p['nama'] }}</p>
                        @if(!empty($p['nim'])) <p class="text-xs text-navy-600/70">{{ $p['nim'] }}</p> @endif
                        @if(!empty($p['universitas'])) <p class="text-xs text-navy-500 leading-tight break-words mt-0.5">{{ $p['universitas'] }}</p> @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Konten Utama (Rich Text) --}}
        <div class="prose prose-base sm:prose-lg prose-custom w-full max-w-none bg-white p-6 sm:p-10 md:p-12 rounded-2xl sm:rounded-3xl shadow-sm border border-navy-900/5 mb-10 overflow-x-hidden">
            {!! $project->konten !!}
        </div>

        {{-- Galeri Foto Dokumentasi --}}
        @if($project->foto_dokumentasi && count($project->foto_dokumentasi) > 0)
        <div class="mb-10">
            <h2 class="text-xl sm:text-2xl font-heading font-bold text-navy-900 mb-5 flex items-center gap-2">
                <svg class="w-6 h-6 text-royal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Dokumentasi Kegiatan
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                @foreach($project->foto_dokumentasi as $i => $foto)
                <div class="relative rounded-xl sm:rounded-2xl overflow-hidden bg-gray-100 aspect-square group cursor-pointer border border-gray-200"
                     @click="$store.lightbox.open = true; $store.lightbox.currentSrc = '{{ asset('storage/' . $foto) }}'; $store.lightbox.currentTitle = '{{ addslashes($project->judul) }} – Dokumentasi {{ $i + 1 }}'; $store.lightbox.isVideo = false">
                    <img src="{{ asset('storage/' . $foto) }}"
                         alt="Dokumentasi {{ $i + 1 }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Tombol Kembali --}}
        <div class="text-center mt-8">
            <a href="{{ route('public.kukerta.index') }}" class="inline-flex items-center px-6 sm:px-8 py-3 bg-navy-900 hover:bg-royal text-white rounded-full font-medium transition-all shadow-md text-sm sm:text-base">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Proker
            </a>
        </div>
    </div>

    {{-- ===== PROKER TERKAIT ===== --}}
    @if($related->count() > 0)
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl mt-16 pt-10 border-t border-navy-900/10">
        <h2 class="text-xl sm:text-2xl font-heading font-bold text-navy-900 mb-6">Proker Terkait</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
            @foreach($related as $rel)
            <a href="{{ route('public.kukerta.show', $rel->slug) }}"
               class="group bg-white rounded-2xl overflow-hidden hover-card-effect flex flex-col border border-gray-200 shadow-sm">
                <div class="relative h-40 overflow-hidden bg-navy-800 shrink-0">
                    @if($rel->thumbnail)
                        <img src="{{ asset('storage/' . $rel->thumbnail) }}" alt="{{ $rel->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-navy-800 to-royal flex items-center justify-center">
                            <svg class="w-10 h-10 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                    @endif
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <p class="text-xs text-navy-500 mb-1 line-clamp-1 font-medium">{{ $rel->pelaksana_names }}</p>
                    <h3 class="font-heading font-bold text-navy-900 group-hover:text-royal transition-colors line-clamp-2 text-sm leading-snug">{{ $rel->judul }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</article>
@endsection
