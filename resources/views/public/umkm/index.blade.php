@extends('layouts.public')
@section('title', 'UMKM & Produk - Desa Pebadaran')

@section('content')
<!-- Page Header -->
<section class="relative pt-24 pb-16 bg-navy-900 border-b-[8px] border-white overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-4 animate-fade-in-up">UMKM & Produk Desa</h1>
        <p class="text-lg text-cream/80 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">Dukung perekonomian lokal dengan membeli produk karya masyarakat Desa Pebadaran.</p>
    </div>
</section>

<!-- Content -->
<section class="py-16 bg-cream min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filter (Placeholder logic) -->
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <a href="{{ route('public.umkm.index') }}" class="px-6 py-2 rounded-full text-sm font-medium transition-colors {{ !request('kategori') ? 'bg-navy-900 text-gold shadow-md' : 'bg-white text-navy-700 hover:bg-navy-50 border border-navy-900/10' }}">Semua Produk</a>
            @if(isset($categories))
                @foreach($categories as $cat)
                <a href="?kategori={{ urlencode($cat) }}" class="px-6 py-2 rounded-full text-sm font-medium transition-colors {{ request('kategori') == $cat ? 'bg-navy-900 text-gold shadow-md' : 'bg-white text-navy-700 hover:bg-navy-50 border border-navy-900/10' }}">{{ $cat }}</a>
                @endforeach
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 xl:gap-8">
            @if(isset($umkms) && $umkms->count() > 0)
                @foreach($umkms as $umkm)
                <a href="{{ route('public.umkm.show', $umkm->id) }}" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-navy-900/5 hover:border-gold/50 flex flex-col h-full hover:-translate-y-1">
                    <div class="relative h-60 overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . $umkm->foto) }}" alt="{{ $umkm->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-4 right-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 text-white font-medium text-center bg-white/20 backdrop-blur-md py-2 rounded-lg border border-white/30">
                            Lihat Detail
                        </div>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-lg font-heading font-bold text-navy-900 mb-1 group-hover:text-royal transition-colors line-clamp-2">{{ $umkm->nama_produk }}</h3>
                        <p class="text-sm text-navy-600 flex items-center mb-4">
                            <svg class="w-4 h-4 mr-1.5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $umkm->nama_penjual }}
                        </p>
                        <div class="mt-auto pt-4 border-t border-navy-900/5">
                            <span class="text-xl font-bold text-royal">Rp {{ number_format($umkm->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            @else
                <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-10 h-10 text-navy-900/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <p class="text-xl text-navy-700/50 font-medium">Belum ada produk UMKM yang terdaftar.</p>
                </div>
            @endif
        </div>
        
        <!-- Pagination (assuming paginated) -->
        @if(isset($umkms) && method_exists($umkms, 'hasPages') && $umkms->hasPages())
        <div class="flex justify-center mt-12">
            {{ $umkms->links() }}
        </div>
        @endif

    </div>
</section>
@endsection
