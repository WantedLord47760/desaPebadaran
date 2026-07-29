<footer class="bg-navy-900 text-cream relative border-t-[3px] border-white mt-auto overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 lg:gap-16">
            
            <!-- Col 1: Brand & Info -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="font-heading font-bold text-2xl text-white tracking-wide">Desa Pebadaran</span>
                </div>
                <p class="text-sm text-cream/70 leading-relaxed">
                    Portal Informasi Terpadu Desa Pebadaran, Kecamatan Pusako, Kabupaten Siak, Riau. Melayani masyarakat dengan transparansi dan inovasi.
                </p>
                <div class="pt-4 border-t border-white/10">
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-gold hover:text-navy-900 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-gold hover:text-navy-900 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div>
                <h3 class="text-gold font-heading font-semibold text-lg mb-4 flex items-center gap-2">
                    <span class="w-8 h-1 bg-gold rounded-full"></span> Tautan Cepat
                </h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('public.beranda') }}" class="text-cream/70 hover:text-white hover:translate-x-1 inline-block transition-all">&rarr; Beranda</a></li>
                    <li><a href="{{ route('public.profil') }}" class="text-cream/70 hover:text-white hover:translate-x-1 inline-block transition-all">&rarr; Profil Desa</a></li>
                    <li><a href="{{ route('public.berita.index') }}" class="text-cream/70 hover:text-white hover:translate-x-1 inline-block transition-all">&rarr; Berita & Informasi</a></li>
                    <li><a href="{{ route('public.umkm.index') }}" class="text-cream/70 hover:text-white hover:translate-x-1 inline-block transition-all">&rarr; UMKM & Produk</a></li>
                    <li><a href="{{ route('public.galeri') }}" class="text-cream/70 hover:text-white hover:translate-x-1 inline-block transition-all">&rarr; Galeri</a></li>
                </ul>
            </div>

            <!-- Col 3: Contact -->
            <div>
                <h3 class="text-gold font-heading font-semibold text-lg mb-4 flex items-center gap-2">
                    <span class="w-8 h-1 bg-gold rounded-full"></span> Kontak
                </h3>
                <ul class="space-y-4 text-cream/70 text-sm">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gold shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Kantor Desa Pebadaran<br>Kec. Pusako, Kab. Siak<br>Riau, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>pemdes@pebadaran.desa.id</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="bg-navy-950 border-t border-white/5 py-4 mt-8 relative z-10 text-center">
        <p class="text-sm text-cream/50 tracking-wider">
            &copy; {{ date('Y') }} Desa Pebadaran. Hak Cipta Dilindungi.<br>
            <span class="text-gold uppercase font-semibold text-xs mt-1 inline-block">dibuat oleh KUKERTA UNRI 2026</span>
        </p>
    </div>
</footer>
