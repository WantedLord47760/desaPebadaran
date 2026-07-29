@extends('layouts.public')
@section('title', $umkm->nama_produk . ' - UMKM Desa Pebadaran')

@section('content')
<section class="py-12 md:py-20 bg-cream min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm text-navy-600">
            <a href="{{ route('public.beranda') }}" class="hover:text-royal transition-colors">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('public.umkm.index') }}" class="hover:text-royal transition-colors">UMKM</a>
            <span class="mx-2">/</span>
            <span class="text-navy-900 font-medium truncate">{{ $umkm->nama_produk }}</span>
        </nav>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-navy-900/5">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- Product Image -->
                <div class="relative h-72 md:h-full min-h-[400px] bg-gray-100 group">
                    <img src="{{ asset('storage/' . $umkm->foto) }}" alt="{{ $umkm->nama_produk }}" class="absolute inset-0 w-full h-full object-cover">
                    <!-- Lightbox trigger -->
                    <button @click="$store.lightbox.open = true; $store.lightbox.currentSrc = '{{ asset('storage/' . $umkm->foto) }}'; $store.lightbox.currentTitle = '{{ $umkm->nama_produk }}'; $store.lightbox.isVideo = false" 
                            class="absolute top-4 right-4 bg-white/80 hover:bg-white backdrop-blur text-navy-900 p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </button>
                </div>

                <!-- Product Info -->
                <div class="p-8 md:p-12 flex flex-col">
                    <div class="mb-2">
                        <span class="inline-block bg-navy-900/10 text-navy-900 border border-navy-900/20 rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider">Produk Lokal</span>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-heading font-bold text-navy-900 mb-4">{{ $umkm->nama_produk }}</h1>
                    
                    <div class="text-3xl font-bold text-royal mb-6">
                        Rp {{ number_format($umkm->harga, 0, ',', '.') }}
                    </div>

                    <div class="flex items-center gap-4 mb-8 pb-8 border-b border-navy-900/10">
                        <div class="w-12 h-12 rounded-full bg-navy-50 flex items-center justify-center text-navy-700">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-navy-600 mb-0.5">Pemilik / Penjual</p>
                            <p class="font-bold text-navy-900">{{ $umkm->nama_penjual }}</p>
                        </div>
                    </div>

                    <div class="mb-10 flex-grow">
                        <h3 class="font-heading font-semibold text-lg text-navy-900 mb-3">Deskripsi Produk</h3>
                        <div class="prose prose-sm text-navy-700/80 leading-relaxed">
                            {!! nl2br(e($umkm->deskripsi)) !!}
                        </div>
                    </div>

                    @php
                        $waText = "Halo, saya tertarik dengan produk {$umkm->nama_produk} yang ada di website Desa Pebadaran.";
                        $waLink = "https://wa.me/" . (preg_replace('/^0/', '62', $umkm->no_whatsapp ?? '')) . "?text=" . urlencode($waText);
                    @endphp

                    <div class="flex flex-col sm:flex-row gap-4 mt-auto">
                        <a href="{{ $waLink }}" target="_blank" class="flex-1 inline-flex items-center justify-center px-6 py-4 bg-[#25D366] hover:bg-[#128C7E] text-white rounded-xl font-bold transition-colors shadow-lg shadow-[#25D366]/30 group">
                            <svg class="w-6 h-6 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 1.856.001 3.598.723 4.907 2.034 1.31 1.311 2.031 3.054 2.03 4.908-.001 3.825-3.113 6.938-6.937 6.938z"/></svg>
                            Hubungi via WhatsApp
                        </a>
                        <a href="{{ route('public.umkm.index') }}" class="inline-flex items-center justify-center px-6 py-4 bg-navy-50 hover:bg-navy-100 text-navy-900 rounded-xl font-medium transition-colors border border-navy-900/10">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
