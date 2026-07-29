@extends('layouts.public')
@section('title', $berita->judul . ' - Desa Pebadaran')

@section('content')
<article class="bg-cream min-h-screen pb-20">
    <!-- Article Hero -->
    <header class="relative pt-20">
        <div class="absolute top-0 inset-x-0 h-64 bg-navy-900 rounded-b-[3rem]"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-4xl pt-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden p-2">
                <div class="relative h-[40vh] min-h-[300px] w-full rounded-2xl overflow-hidden">
                    <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
                    <div class="absolute top-6 left-6 bg-navy-900 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg backdrop-blur-sm bg-opacity-90">
                        {{ $berita->kategori->nama ?? 'Berita' }}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Article Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl mt-12">
        <div class="mb-8 text-center">
            <div class="inline-flex items-center text-sm text-navy-700 mb-4 bg-navy-900/5 px-4 py-1.5 rounded-full">
                <svg class="w-4 h-4 mr-2 text-royal" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Diterbitkan pada {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('l, d F Y') }}
                <span class="mx-3 text-navy-900/30">|</span>
                <svg class="w-4 h-4 mr-2 text-royal" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Admin
            </div>
            <h1 class="text-3xl md:text-5xl font-heading font-bold text-navy-900 leading-tight mb-8">{{ $berita->judul }}</h1>
            <div class="w-24 h-1 bg-navy-900 mx-auto rounded-full mb-8"></div>
        </div>

        <div class="prose prose-lg prose-custom w-full max-w-none bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-navy-900/5">
            {!! $berita->konten !!}
        </div>

        <!-- Back Button -->
        <div class="mt-12 text-center">
            <a href="{{ route('public.berita.index') }}" class="inline-flex items-center px-8 py-3 bg-navy-900 hover:bg-navy-800 text-white rounded-full font-medium transition-all hover:-translate-x-2 shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Berita
            </a>
        </div>
    </div>
</article>
@endsection
