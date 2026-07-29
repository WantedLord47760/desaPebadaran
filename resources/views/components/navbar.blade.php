<nav x-data="{ scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)" 
     :class="{ 'glass py-2 shadow-lg': scrolled, 'bg-navy-900 py-4': !scrolled }"
     class="fixed w-full top-0 z-40 transition-all duration-300 border-b border-white/20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('public.beranda') }}" class="flex items-center gap-3 group">
                @php $logo = \App\Models\ProfilDesa::where('key', 'logo')->value('value'); @endphp
                @if($logo)
                    <img src="{{ Storage::url($logo) }}" alt="Logo" class="h-10 w-auto group-hover:scale-110 transition-transform duration-300">
                @else
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center border border-white/20 group-hover:bg-white/20 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                @endif
                <div class="flex flex-col">
                    <span class="font-heading font-bold text-xl text-white tracking-wide">{{ \App\Models\ProfilDesa::where('key', 'nama_desa')->value('value') ?? 'Desa Pebadaran' }}</span>
                    <span class="text-xs text-gold-light uppercase tracking-widest hidden sm:block">Sistem Informasi Terpadu</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-1">
                @php
                    $navItems = [
                        ['route' => 'public.beranda', 'label' => 'Beranda'],
                        ['route' => 'public.profil', 'label' => 'Profil Desa'],
                        ['route' => 'public.berita.index', 'label' => 'Berita'],
                        ['route' => 'public.umkm.index', 'label' => 'UMKM & Produk'],
                        ['route' => 'public.galeri', 'label' => 'Galeri'],
                        ['route' => 'public.kukerta.index', 'label' => 'KUKERTA'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ request()->routeIs($item['route'] . '*') ? 'text-white bg-royal/80 shadow-inner' : 'text-cream/80 hover:text-white hover:bg-white/10' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center">
                <button @click="$store.mobileMenu.open = !$store.mobileMenu.open" class="text-white hover:text-gold focus:outline-none">
                    <svg class="h-6 w-6" x-show="!$store.mobileMenu.open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" x-show="$store.mobileMenu.open" style="display:none;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Panel -->
    <div x-show="$store.mobileMenu.open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.away="$store.mobileMenu.open = false"
         class="lg:hidden absolute top-full left-0 w-full bg-navy-900 border-b border-white shadow-2xl" style="display: none;">
        <div class="px-4 pt-2 pb-6 space-y-1">
            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}" 
                   class="block px-3 py-3 rounded-md text-base font-medium {{ request()->routeIs($item['route'] . '*') ? 'bg-royal text-white' : 'text-cream/80 hover:bg-white/5 hover:text-white' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>
