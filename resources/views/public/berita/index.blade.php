@extends('layouts.public')
@section('title', 'Berita & Informasi - Desa Pebadaran')

@section('content')
<!-- Page Header -->
<section class="relative pt-24 pb-16 bg-navy-900 border-b-[8px] border-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-4 animate-fade-in-up">Berita & Informasi</h1>
        <p class="text-lg text-cream/80 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">Kabar terbaru dan pengumuman resmi dari Pemerintah Desa Pebadaran.</p>
    </div>
</section>

<!-- Content -->
<section class="py-16 bg-cream min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @if(isset($beritas) && $beritas->count() > 0)
                @foreach($beritas as $berita)
                <article class="bg-white rounded-2xl overflow-hidden shadow-md hover-card-effect group flex flex-col h-full border border-navy-900/5 relative">
                    <a href="{{ route('public.berita.show', $berita->slug) }}" class="absolute inset-0 z-10"></a>
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4 bg-navy-900 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                            {{ $berita->kategori->nama ?? 'Umum' }}
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="text-xs text-navy-700/70 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-royal" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('l, d F Y') }}
                        </div>
                        <h2 class="text-xl font-heading font-bold text-navy-900 mb-3 line-clamp-2 group-hover:text-royal transition-colors relative z-20">
                            <a href="{{ route('public.berita.show', $berita->slug) }}">{{ $berita->judul }}</a>
                        </h2>
                        <p class="text-navy-800/80 text-sm mb-6 line-clamp-3 flex-grow relative z-20">{{ Str::limit(strip_tags($berita->konten), 120) }}</p>
                        <a href="{{ route('public.berita.show', $berita->slug) }}" class="inline-flex items-center justify-between w-full pt-4 border-t border-navy-900/10 text-sm font-semibold text-royal group-hover:text-royal-light mt-auto relative z-20">
                            <span>Baca Selengkapnya</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </article>
                @endforeach
            @else
                <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                    <svg class="w-16 h-16 text-navy-900/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <p class="text-xl text-navy-700/50 font-medium">Belum ada berita yang diterbitkan.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if(isset($beritas) && $beritas->hasPages())
        <div class="flex justify-center mt-8">
            {{ $beritas->links() }}
        </div>
        @endif

    </div>
</section>
@endsection
