@extends('layouts.public')
@section('title', 'Galeri - Desa Pebadaran')

@section('content')
<!-- Page Header -->
<section class="relative pt-24 pb-16 bg-navy-900 border-b-[8px] border-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-4 animate-fade-in-up">Galeri Desa</h1>
        <p class="text-lg text-cream/80 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">Dokumentasi kegiatan dan pesona Desa Pebadaran.</p>
    </div>
</section>

<!-- Content -->
<section class="py-12 bg-cream min-h-screen" x-data="{ filter: 'semua' }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filter Tabs -->
        <div class="flex justify-center gap-4 mb-12">
            <button @click="filter = 'semua'" :class="filter === 'semua' ? 'bg-navy-900 text-gold shadow-md' : 'bg-white text-navy-700 hover:bg-navy-50'" class="px-6 py-2 rounded-full font-medium transition-colors border border-transparent border-navy-900/10">Semua</button>
            <button @click="filter = 'foto'" :class="filter === 'foto' ? 'bg-navy-900 text-gold shadow-md' : 'bg-white text-navy-700 hover:bg-navy-50'" class="px-6 py-2 rounded-full font-medium transition-colors border border-transparent border-navy-900/10">Foto</button>
            <button @click="filter = 'video'" :class="filter === 'video' ? 'bg-navy-900 text-gold shadow-md' : 'bg-white text-navy-700 hover:bg-navy-50'" class="px-6 py-2 rounded-full font-medium transition-colors border border-transparent border-navy-900/10">Video</button>
        </div>

        <!-- Masonry Grid (Simulated with columns) -->
        <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6">
            @if(isset($galeris) && $galeris->count() > 0)
                @foreach($galeris as $item)
                @php
                    $src = asset('storage/' . $item->file_path);
                    $isVid = strtolower($item->tipe) == 'video';
                    $isLocalVid = false;
                    $thumbnailUrl = $src; // default to the image itself

                    if ($isVid) {
                        if (filter_var($item->file_path, FILTER_VALIDATE_URL)) {
                            // YouTube Video
                            $src = $item->file_path;
                            $ytId = '';
                            if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $src, $id)) {
                                $ytId = $id[1];
                                $src = 'https://www.youtube.com/embed/' . $ytId;
                            } else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $src, $id)) {
                                $ytId = $id[1];
                                $src = 'https://www.youtube.com/embed/' . $ytId;
                            }
                            
                            if ($ytId) {
                                $thumbnailUrl = 'https://img.youtube.com/vi/' . $ytId . '/hqdefault.jpg';
                            } else {
                                $thumbnailUrl = 'https://ui-avatars.com/api/?name=Video&background=0F1B33&color=C4A35A&size=600';
                            }
                        } else {
                            // Local uploaded video
                            $isLocalVid = true;
                            $thumbnailUrl = null; // We'll handle this in the view with an icon
                        }
                    }
                @endphp
                <div x-show="filter === 'semua' || filter === '{{ strtolower($item->tipe) }}'" 
                     x-transition.opacity.duration.500ms
                     class="break-inside-avoid relative rounded-2xl overflow-hidden group cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 bg-navy-900"
                     @click="$store.lightbox.open = true; 
                             $store.lightbox.currentTitle = '{{ addslashes($item->judul) }}'; 
                             $store.lightbox.isVideo = {{ $isVid ? 'true' : 'false' }};
                             $store.lightbox.isLocalVideo = {{ $isLocalVid ? 'true' : 'false' }};
                             $store.lightbox.currentSrc = '{{ $src }}'">
                    
                    @if($isVid && $isLocalVid)
                        <div class="w-full aspect-video flex flex-col items-center justify-center bg-navy-800 text-cream/50 group-hover:bg-navy-700 transition-colors">
                            <svg class="w-16 h-16 mb-2 opacity-50 group-hover:opacity-100 transition-opacity group-hover:scale-110 duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            <span class="text-sm font-medium">Video File</span>
                        </div>
                    @else
                        <img src="{{ $thumbnailUrl }}" 
                             alt="{{ $item->judul }}" 
                             class="w-full h-auto object-cover group-hover:scale-110 transition-transform duration-700">
                    @endif
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-900 via-navy-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Type Icon -->
                    <div class="absolute top-4 right-4 bg-navy-900/80 backdrop-blur text-white p-2 rounded-full shadow-lg">
                        @if($isVid)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        @else
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @endif
                    </div>

                    <!-- Title (Visible on hover) -->
                    <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                        <h3 class="text-white font-heading font-bold text-lg leading-tight shadow-sm">{{ $item->judul }}</h3>
                    </div>
                </div>
                @endforeach
            @else
                <div class="w-full text-center py-20 col-span-full break-inside-avoid">
                    <svg class="w-16 h-16 text-navy-900/20 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-xl text-navy-700/50 font-medium">Galeri belum memiliki konten.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
