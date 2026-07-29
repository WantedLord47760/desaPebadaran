<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Resmi Desa Pebadaran. Sistem Informasi Desa terpadu untuk masyarakat.">
    <title>@yield('title', 'Desa Pebadaran')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen flex flex-col font-sans relative">
    
    @include('components.navbar')

    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    @include('components.footer')

    <!-- Global Lightbox Overlay (Alpine.js controlled) -->
    <div x-data
         x-show="$store.lightbox.open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 lightbox-overlay"
         @keydown.escape.window="$store.lightbox.open = false"
         style="display: none;">
         
        <div class="absolute inset-0 bg-black/60" @click="$store.lightbox.open = false"></div>
        
        <div class="relative w-full max-w-5xl max-h-full flex flex-col items-center justify-center">
            <button @click="$store.lightbox.open = false" class="absolute -top-10 right-0 text-white hover:text-gold transition-colors z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="relative w-full rounded-xl overflow-hidden shadow-2xl bg-navy-900 border border-gold/30">
                <template x-if="!$store.lightbox.isVideo">
                    <img :src="$store.lightbox.currentSrc" :alt="$store.lightbox.currentTitle" class="w-full max-h-[80vh] object-contain">
                </template>
                <template x-if="$store.lightbox.isVideo && !$store.lightbox.isLocalVideo">
                    <div class="aspect-video w-full bg-black">
                        <!-- Video embed placeholder, actual src bound below -->
                        <iframe :src="$store.lightbox.currentSrc" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </template>
                <template x-if="$store.lightbox.isVideo && $store.lightbox.isLocalVideo">
                    <div class="aspect-video w-full bg-black flex items-center justify-center">
                        <video :src="$store.lightbox.currentSrc" class="w-full max-h-[80vh]" controls autoplay controlsList="nodownload"></video>
                    </div>
                </template>
                <div x-show="$store.lightbox.currentTitle" class="absolute bottom-0 inset-x-0 bg-navy-900/90 backdrop-blur text-white p-4 text-center">
                    <p class="font-heading font-semibold text-lg" x-text="$store.lightbox.currentTitle"></p>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
