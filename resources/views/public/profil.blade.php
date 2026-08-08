@extends('layouts.public')
@section('title', 'Profil Desa - Desa Pebadaran')

@section('content')
<!-- Page Header -->
<section class="relative pt-24 pb-16 bg-navy-900 border-b-[8px] border-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-4 animate-fade-in-up">Profil Desa Pebadaran</h1>
        <p class="text-lg text-cream/80 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">Mengenal lebih dekat sejarah, visi misi, dan struktur pemerintahan Desa Pebadaran.</p>
    </div>
</section>

<!-- Content with Tabs -->
<section class="py-12 bg-cream min-h-screen" x-data="{ activeTab: 'sejarah', showPdfModal: false }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        
        <!-- Tab Navigation -->
        <div class="flex flex-wrap justify-center gap-2 mb-10 border-b border-gold/30 pb-4">
            @php
                $tabs = [
                    'sejarah' => 'Sejarah',
                    'geografi' => 'Geografi',
                    'visimisi' => 'Visi & Misi',
                    'struktur' => 'Struktur Organisasi',
                    'demografi' => 'Demografi',
                    'buku-profil' => 'Buku Profil Desa'
                ];
            @endphp
            @foreach($tabs as $key => $label)
            <button @click="activeTab = '{{ $key }}'" 
                    :class="activeTab === '{{ $key }}' ? 'bg-navy-900 text-gold shadow-md scale-105' : 'bg-white text-navy-700 hover:bg-navy-50'"
                    class="px-5 py-2.5 rounded-full font-heading font-medium transition-all duration-300 text-sm md:text-base border border-transparent flex items-center gap-2">
                @if($key === 'buku-profil')
                    <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                @endif
                {{ $label }}
            </button>
            @endforeach
        </div>

        <!-- Tab Contents -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-navy-900/5">
            
            <!-- Sejarah -->
            <div x-show="activeTab === 'sejarah'" x-transition.opacity class="p-6 md:p-10 prose prose-lg prose-custom max-w-none">
                <h2 class="text-3xl font-heading font-bold text-navy-900 flex items-center gap-3">
                    <span class="w-1.5 h-8 bg-gold rounded-full inline-block"></span> Sejarah Desa
                </h2>
                <div class="mt-6">
                    {!! $profil['sejarah'] ?? '<p>Informasi sejarah desa belum tersedia.</p>' !!}
                </div>
            </div>

            <!-- Geografi -->
            <div x-show="activeTab === 'geografi'" x-transition.opacity class="p-6 md:p-10" style="display: none;">
                <h2 class="text-3xl font-heading font-bold text-navy-900 flex items-center gap-3 mb-8">
                    <span class="w-1.5 h-8 bg-gold rounded-full inline-block"></span> Kondisi Geografis
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="bg-cream rounded-xl p-6 border border-gold/20">
                            <h3 class="font-heading font-semibold text-xl text-navy-800 mb-4 border-b border-gold/20 pb-2">Batas Wilayah</h3>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <span class="w-24 font-medium text-navy-700">Utara</span>
                                    <span class="text-navy-900">: {{ $profil['batas_utara'] ?? '-' }}</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="w-24 font-medium text-navy-700">Selatan</span>
                                    <span class="text-navy-900">: {{ $profil['batas_selatan'] ?? '-' }}</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="w-24 font-medium text-navy-700">Timur</span>
                                    <span class="text-navy-900">: {{ $profil['batas_timur'] ?? '-' }}</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="w-24 font-medium text-navy-700">Barat</span>
                                    <span class="text-navy-900">: {{ $profil['batas_barat'] ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="bg-navy-900 text-white rounded-xl p-6 shadow-md">
                            <h3 class="font-heading font-semibold text-xl text-gold mb-2">Luas Wilayah</h3>
                            <p class="text-3xl font-bold">{{ $profil['luas_wilayah'] ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="h-64 md:h-full min-h-[300px] bg-gray-200 rounded-xl overflow-hidden relative shadow-inner">
                        @php
                            $mapQuery = urlencode(($profil['nama_desa'] ?? 'Desa Pebadaran') . ', ' . ($profil['kecamatan'] ?? '') . ', ' . ($profil['kabupaten'] ?? ''));
                        @endphp
                        <iframe 
                            src="https://maps.google.com/maps?q={{ $mapQuery }}&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            style="border:0;" 
                            allowfullscreen="" 
                            aria-hidden="false" 
                            tabindex="0"
                            class="absolute inset-0 w-full h-full">
                        </iframe>
                    </div>
                </div>

                {{-- VR Kampung Pebadaran Banner --}}
                <div class="mt-8 relative overflow-hidden rounded-2xl border border-white/10 shadow-xl bg-navy-900 p-0.5">
                    <div class="relative rounded-[14px] overflow-hidden bg-navy-900">
                        {{-- Glow orb --}}
                        <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>

                        <div class="relative flex flex-col md:flex-row items-center gap-6 p-6 md:p-8">
                            {{-- VR Icon --}}
                            <div class="flex-shrink-0 w-20 h-20 md:w-24 md:h-24 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center shadow-inner">
                                <svg class="w-10 h-10 md:w-12 md:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 3.75H5.25a1.5 1.5 0 00-1.5 1.5v4.5m5.25-6h9a1.5 1.5 0 011.5 1.5v4.5m0 0v9a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-9m15 0H3.75m5.25 0a2.25 2.25 0 104.5 0 2.25 2.25 0 00-4.5 0z" />
                                </svg>
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 text-center md:text-left">
                                <span class="inline-block px-3 py-1 rounded-full bg-white/15 text-white text-xs font-bold uppercase tracking-widest mb-2 border border-white/20">
                                    Program Kerja KUKERTA
                                </span>
                                <h3 class="text-xl md:text-2xl font-heading font-bold text-white mb-1.5 leading-tight">
                                    Virtual Reality Kampung Pebadaran
                                </h3>
                                <p class="text-white/60 text-sm md:text-base leading-relaxed max-w-xl">
                                    Jelajahi Desa Pebadaran secara imersif melalui tur virtual 360°. Lihat setiap sudut kampung kami dari mana saja dan kapan saja menggunakan teknologi Virtual Reality.
                                </p>
                                <div class="mt-2 flex flex-wrap gap-2 justify-center md:justify-start">
                                    <span class="inline-flex items-center gap-1.5 text-xs text-white/60 bg-white/5 px-2.5 py-1 rounded-full border border-white/10">
                                        <svg class="w-3 h-3 text-white/80" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        Tersedia Online
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-xs text-white/60 bg-white/5 px-2.5 py-1 rounded-full border border-white/10">
                                        <svg class="w-3 h-3 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                                        Tour 360° Imersif
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-xs text-white/60 bg-white/5 px-2.5 py-1 rounded-full border border-white/10">
                                        <svg class="w-3 h-3 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        Mendukung VR Headset
                                    </span>
                                </div>
                            </div>

                            {{-- CTA Button --}}
                            <div class="flex-shrink-0">
                                <a href="https://pebadaran-vr.vercel.app/" target="_blank" rel="noopener noreferrer"
                                   class="group inline-flex items-center gap-3 px-6 py-3.5 rounded-xl bg-white hover:bg-white/90 text-navy-900 font-bold text-sm md:text-base shadow-lg transition-all duration-300 hover:scale-105 whitespace-nowrap">
                                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Jelajahi VR Desa
                                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visi Misi -->
            <div x-show="activeTab === 'visimisi'" x-transition.opacity class="p-6 md:p-10" style="display: none;">
                <div class="text-center max-w-4xl mx-auto mb-16">
                    <h2 class="text-2xl font-heading font-bold text-gold uppercase tracking-widest mb-4">Visi</h2>
                    <p class="text-2xl md:text-3xl font-medium text-navy-900 leading-relaxed italic">
                        "{{ $visi->konten ?? 'Terwujudnya Desa Pebadaran yang Mandiri, Sejahtera, dan Berbudaya.' }}"
                    </p>
                </div>
                
                <div class="max-w-3xl mx-auto">
                    <h2 class="text-2xl font-heading font-bold text-navy-900 mb-6 flex items-center gap-3">
                        <span class="w-1.5 h-8 bg-gold rounded-full inline-block"></span> Misi Desa
                    </h2>
                    <ul class="space-y-4">
                        @if(isset($misi) && $misi->count() > 0)
                            @foreach($misi as $index => $item)
                            <li class="flex items-start bg-cream p-5 rounded-xl shadow-sm border border-gold/10 hover-card-effect">
                                <span class="flex-shrink-0 w-10 h-10 bg-navy-900 text-gold rounded-full flex items-center justify-center font-bold text-lg mr-4">{{ $index + 1 }}</span>
                                <p class="text-navy-800 text-lg pt-1.5">{{ $item->konten }}</p>
                            </li>
                            @endforeach
                        @else
                            <li class="p-4 text-center text-navy-700/50">Data misi belum tersedia.</li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Struktur Organisasi -->
            <div x-show="activeTab === 'struktur'" x-transition.opacity class="p-6 md:p-10 bg-[#0F1B33]" style="display: none;">
                <h2 class="text-3xl font-heading font-bold text-white text-center mb-12">Struktur Pemerintahan Desa</h2>
                
                @if(isset($struktur) && $struktur->count() > 0)
                    @php
                        $bapekam = $struktur->filter(fn($s) => str_contains(strtoupper($s->jabatan), 'BAPEKAM'))->first();
                        $penghulu = $struktur->filter(fn($s) => str_contains(strtoupper($s->jabatan), 'PENGHULU') || str_contains(strtoupper($s->jabatan), 'KEPALA DESA'))->first();
                        
                        $kerani = $struktur->filter(fn($s) => str_contains(strtoupper($s->jabatan), 'KERANI') || str_contains(strtoupper($s->jabatan), 'SEKRETARIS'));
                        $kaur = $struktur->filter(fn($s) => str_contains(strtoupper($s->jabatan), 'KAUR'));
                        $juruTulis = $struktur->filter(fn($s) => str_contains(strtoupper($s->jabatan), 'JURU TULIS') || str_contains(strtoupper($s->jabatan), 'KASI'));
                        $kadus = $struktur->filter(fn($s) => str_contains(strtoupper($s->jabatan), 'KADUS') || str_contains(strtoupper($s->jabatan), 'DUSUN'));
                        
                        $matched_ids = collect([$bapekam?->id, $penghulu?->id])
                            ->merge($kerani->pluck('id'))
                            ->merge($kaur->pluck('id'))
                            ->merge($juruTulis->pluck('id'))
                            ->merge($kadus->pluck('id'))
                            ->filter();
                        $others = $struktur->whereNotIn('id', $matched_ids);
                    @endphp

                    <!-- Node Template Macro -->
                    @php
                        $renderNode = function($pejabat, $bgColor = 'bg-[#1B2A4A]') {
                            if (!$pejabat) return '';
                            $fotoUrl = $pejabat->foto ? asset('storage/'.$pejabat->foto) : 'https://ui-avatars.com/api/?name='.urlencode($pejabat->nama).'&background=1E3058&color=FFFFFF';
                            return '
                            <div class="relative flex flex-col items-center group z-10">
                                <div class="'.$bgColor.' border-2 border-[#1E3058] rounded-xl p-3 sm:p-4 w-40 sm:w-48 shadow-lg transition-transform transform hover:-translate-y-1 hover:shadow-xl text-center">
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto rounded-full overflow-hidden mb-3 border-2 border-white/20 bg-gray-200">
                                        <img src="'.$fotoUrl.'" alt="'.$pejabat->nama.'" class="w-full h-full object-cover">
                                    </div>
                                    <h3 class="font-bold text-white text-sm sm:text-base leading-tight mb-1 truncate">'.$pejabat->nama.'</h3>
                                    <p class="text-white/60 text-xs sm:text-sm font-semibold truncate uppercase">'.$pejabat->jabatan.'</p>
                                </div>
                            </div>';
                        };
                    @endphp

                    <div class="w-full overflow-x-auto pb-8 hide-scrollbar">
                        <div class="min-w-[800px] flex flex-col items-center">
                            
                            <!-- TOP LEVEL (BAPEKAM & PENGHULU) -->
                            <div class="flex items-center justify-center gap-16 relative w-full mb-12">
                                <!-- Dashed line between Bapekam & Penghulu -->
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 border-t-2 border-dashed border-[#1E3058] -z-0 hidden md:block"></div>
                                
                                @if($bapekam)
                                    <div class="relative">
                                        {!! $renderNode($bapekam, 'bg-[#2E5090]') !!}
                                    </div>
                                @endif
                                
                                @if($penghulu)
                                    <div class="relative flex flex-col items-center">
                                        {!! $renderNode($penghulu, 'bg-[#2E5090]') !!}
                                        <!-- Vertical line down from Penghulu -->
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 h-12 border-l-2 border-[#1E3058] -z-0"></div>
                                    </div>
                                @endif
                            </div>

                            <!-- HORIZONTAL BRANCHING LINE -->
                            <div class="relative w-full max-w-4xl flex justify-center mb-8">
                                <div class="absolute top-0 w-full lg:w-4/5 border-t-2 border-[#1E3058] -z-0"></div>
                                
                                <div class="w-full flex justify-between px-4 lg:px-12 relative pt-8">
                                    
                                    <!-- BRANCH 1: KERANI -->
                                    <div class="flex flex-col items-center relative">
                                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-8 h-8 border-l-2 border-[#1E3058] -z-0"></div>
                                        <div class="space-y-6 flex flex-col items-center">
                                            @foreach($kerani as $item)
                                                {!! $renderNode($item) !!}
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- BRANCH 2: KAUR -->
                                    <div class="flex flex-col items-center relative">
                                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-8 h-8 border-l-2 border-[#1E3058] -z-0"></div>
                                        <div class="space-y-6 flex flex-col items-center relative">
                                            <!-- Vertical connecting line for multiples -->
                                            @if($kaur->count() > 1)
                                            <div class="absolute top-0 left-1/2 -translate-x-1/2 h-full border-l-2 border-[#1E3058] -z-0"></div>
                                            @endif
                                            @foreach($kaur as $item)
                                                {!! $renderNode($item) !!}
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- BRANCH 3: JURU TULIS -->
                                    <div class="flex flex-col items-center relative">
                                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-8 h-8 border-l-2 border-[#1E3058] -z-0"></div>
                                        <div class="space-y-6 flex flex-col items-center relative">
                                            <!-- Vertical connecting line for multiples -->
                                            @if($juruTulis->count() > 1)
                                            <div class="absolute top-0 left-1/2 -translate-x-1/2 h-full border-l-2 border-[#1E3058] -z-0"></div>
                                            @endif
                                            @foreach($juruTulis as $item)
                                                {!! $renderNode($item) !!}
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- BRANCH 4: KADUS -->
                                    <div class="flex flex-col items-center relative">
                                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-8 h-8 border-l-2 border-[#1E3058] -z-0"></div>
                                        <div class="space-y-6 flex flex-col items-center relative">
                                            <!-- Vertical connecting line for multiples -->
                                            @if($kadus->count() > 1)
                                            <div class="absolute top-0 left-1/2 -translate-x-1/2 h-full border-l-2 border-[#1E3058] -z-0"></div>
                                            @endif
                                            @foreach($kadus as $item)
                                                {!! $renderNode($item) !!}
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                            
                            <!-- OTHERS (If any) -->
                            @if($others->count() > 0)
                            <div class="mt-16 w-full max-w-4xl border-t border-white/10 pt-8">
                                <h3 class="text-white text-center mb-6 font-semibold">Lainnya</h3>
                                <div class="flex flex-wrap justify-center gap-6">
                                    @foreach($others as $item)
                                        {!! $renderNode($item) !!}
                                    @endforeach
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                @else
                    <div class="w-full text-center py-12 text-cream/50">Data struktur organisasi belum tersedia.</div>
                @endif
            </div>

            <!-- Demografi -->
            <div x-show="activeTab === 'demografi'" x-transition.opacity class="p-6 md:p-10" style="display: none;">
                <h2 class="text-3xl font-heading font-bold text-navy-900 flex items-center gap-3 mb-8">
                    <span class="w-1.5 h-8 bg-gold rounded-full inline-block"></span> Demografi Penduduk
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Simple Bar Chart Placeholder (CSS based) -->
                    <div class="bg-cream rounded-xl p-6 border border-navy-900/10">
                        <h3 class="font-heading font-semibold text-lg text-navy-900 mb-6 text-center">Berdasarkan Jenis Kelamin</h3>
                        <div class="flex items-end justify-center gap-8 h-48 pb-4 border-b border-navy-900/20">
                            @php
                                $totalL = $demografi['laki_laki'] ?? 50;
                                $totalP = $demografi['perempuan'] ?? 50;
                                $total = $totalL + $totalP ?: 1;
                                $pctL = round(($totalL / $total) * 100);
                                $pctP = round(($totalP / $total) * 100);
                            @endphp
                            <!-- Bar Laki -->
                            <div class="flex flex-col items-center group">
                                <span class="text-sm font-bold text-navy-800 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">{{ $totalL }} ({{ $pctL }}%)</span>
                                <div class="w-16 bg-royal rounded-t-lg transition-all duration-1000 ease-out" style="height: {{ $pctL }}%;"></div>
                                <span class="mt-3 font-medium text-navy-700">Laki-laki</span>
                            </div>
                            <!-- Bar Perempuan -->
                            <div class="flex flex-col items-center group">
                                <span class="text-sm font-bold text-navy-800 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">{{ $totalP }} ({{ $pctP }}%)</span>
                                <div class="w-16 bg-gold rounded-t-lg transition-all duration-1000 ease-out" style="height: {{ $pctP }}%;"></div>
                                <span class="mt-3 font-medium text-navy-700">Perempuan</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-cream rounded-xl p-6 border border-navy-900/10">
                        <h3 class="font-heading font-semibold text-lg text-navy-900 mb-6 text-center">Berdasarkan Kelompok Umur</h3>
                        <div class="space-y-4">
                            @php
                                $kelompokUmur = $demografi['kelompok_umur'] ?? ['0-14 Tahun' => 25, '15-24 Tahun' => 20, '25-54 Tahun' => 45, '55+ Tahun' => 10];
                            @endphp
                            @foreach($kelompokUmur as $label => $val)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-navy-800">{{ $label }}</span>
                                    <span class="text-navy-600">{{ $val }}%</span>
                                </div>
                                <div class="w-full bg-navy-900/10 rounded-full h-2">
                                    <div class="bg-royal h-2 rounded-full" style="width: {{ $val }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buku Profil Desa -->
            <div x-show="activeTab === 'buku-profil'" x-transition.opacity class="p-6 md:p-10" style="display: none;">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 pb-6 mb-8 border-b border-navy-900/10">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gold/20 text-navy-900 mb-2">
                            <svg class="w-3.5 h-3.5 text-navy-900" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                            Dokumen Resmi PDF
                        </span>
                        <h2 class="text-3xl font-heading font-bold text-navy-900 flex items-center gap-3">
                            <span class="w-1.5 h-8 bg-gold rounded-full inline-block"></span> Buku Profil Desa Pebadaran
                        </h2>
                        <p class="text-navy-700 mt-1">Unduh atau baca langsung publikasi profil lengkap Desa Pebadaran.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ asset('bukuProfile.pdf') }}" download="Buku_Profil_Desa_Pebadaran.pdf" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gold hover:bg-gold-dark text-navy-900 font-semibold shadow-md transition-all duration-200 hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh PDF (19.8 MB)
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Column 1: Cover PDF Display -->
                    <div class="lg:col-span-5 flex flex-col items-center">
                        <div class="relative group max-w-sm w-full">
                            <!-- Glow & shadow background -->
                            <div class="absolute -inset-1 bg-gradient-to-r from-gold/50 to-navy-900/40 rounded-2xl blur-md opacity-70 group-hover:opacity-100 transition duration-300"></div>
                            
                            <!-- 3D Book Frame -->
                            <div class="relative rounded-2xl overflow-hidden border-2 border-navy-900/10 bg-white shadow-2xl transition-transform duration-300 group-hover:-translate-y-1.5">
                                <img src="{{ asset('images/buku_profile_cover.jpg') }}" alt="Cover Buku Profil Desa Pebadaran" class="w-full h-auto object-cover">
                                
                                <div class="absolute top-4 right-4 bg-navy-900/90 backdrop-blur text-gold text-xs font-bold px-3 py-1.5 rounded-full border border-gold/30 shadow">
                                    29 Halaman • PDF
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons under Cover -->
                        <div class="mt-6 flex flex-col sm:flex-row gap-3 w-full max-w-sm">
                            <button @click="showPdfModal = true" class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-3 rounded-xl bg-navy-900 text-white font-medium hover:bg-navy-800 transition shadow">
                                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Mode Layar Penuh
                            </button>
                            <a href="{{ asset('bukuProfile.pdf') }}" target="_blank" class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-3 rounded-xl bg-cream border border-navy-900/20 text-navy-900 font-medium hover:bg-navy-50 transition shadow-sm">
                                <svg class="w-5 h-5 text-navy-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Tab Baru
                            </a>
                        </div>
                    </div>

                    <!-- Column 2: Overview & Pokok Bahasan -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="bg-cream rounded-xl p-6 border border-gold/20">
                            <h3 class="font-heading font-semibold text-xl text-navy-900 mb-3 border-b border-gold/20 pb-2">Tentang Buku Profil</h3>
                            <p class="text-navy-800 leading-relaxed text-sm sm:text-base">
                                Buku Profil Desa Pebadaran merupakan dokumen publikasi resmi yang menyajikan informasi komprehensif mengenai sejarah, kondisi geografis, data kependudukan, struktur organisasi pemerintahan desa, potensi ekonomi, sarana prasarana, serta program kerja pembangunan desa.
                            </p>
                        </div>

                        <!-- Highlights List -->
                        <div class="bg-white rounded-xl p-6 border border-navy-900/10 shadow-sm space-y-4">
                            <h3 class="font-heading font-semibold text-lg text-navy-900 border-b border-navy-900/10 pb-2">Pokok Bahasan Buku Profil</h3>
                            <ul class="space-y-3.5 text-sm text-navy-800">
                                <li class="flex items-start gap-3">
                                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-navy-900 text-gold text-xs flex items-center justify-center font-bold">1</span>
                                    <div>
                                        <strong class="text-navy-900 font-semibold">Gambaran Umum & Sejarah Desa</strong>
                                        <p class="text-navy-600 text-xs mt-0.5">Asal usul nama Desa Pebadaran, sejarah berdiri, serta milestone pembangunan desa.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-navy-900 text-gold text-xs flex items-center justify-center font-bold">2</span>
                                    <div>
                                        <strong class="text-navy-900 font-semibold">Kondisi Geografis & Demografi</strong>
                                        <p class="text-navy-600 text-xs mt-0.5">Luas wilayah, batas wilayah, statistik demografi penduduk, serta potensi lahan desa.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-navy-900 text-gold text-xs flex items-center justify-center font-bold">3</span>
                                    <div>
                                        <strong class="text-navy-900 font-semibold">Visi, Misi & Kelembagaan</strong>
                                        <p class="text-navy-600 text-xs mt-0.5">Visi dan misi kepala desa, struktur organisasi pemerintahan desa, Bapekam, dan perangkat desa.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-navy-900 text-gold text-xs flex items-center justify-center font-bold">4</span>
                                    <div>
                                        <strong class="text-navy-900 font-semibold">Potensi Ekonomi, UMKM & Fasilitas Desa</strong>
                                        <p class="text-navy-600 text-xs mt-0.5">Produk unggulan UMKM, sarana pendidikan, sarana ibadah, kesehatan, dan infrastruktur desa.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Embedded PDF Viewer -->
                <div class="mt-10 border-t border-navy-900/10 pt-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-heading font-semibold text-xl text-navy-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Pratinjau Langsung PDF
                        </h3>
                        <span class="text-xs text-navy-700">Gunakan kontrol PDF untuk zoom dan navigasi halaman</span>
                    </div>
                    <div class="w-full bg-gray-900 rounded-2xl overflow-hidden shadow-xl border border-navy-900/20 aspect-[4/3] sm:h-[680px]">
                        <iframe src="{{ asset('bukuProfile.pdf') }}#toolbar=1" class="w-full h-full border-0"></iframe>
                    </div>
                </div>
            </div>

        </div>

        <!-- Dedicated Buku Profil Quick Banner (Appears on all tab views for high visibility) -->
        <div class="mt-10 bg-gradient-to-r from-navy-900 via-navy-800 to-navy-900 rounded-2xl p-6 sm:p-8 text-white shadow-xl border border-gold/30 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-20 flex-shrink-0 rounded-lg overflow-hidden border border-gold/40 shadow-lg hidden sm:block">
                    <img src="{{ asset('images/buku_profile_cover.jpg') }}" alt="Cover Buku Profil" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="inline-block px-2.5 py-0.5 rounded bg-gold/20 text-gold text-xs font-semibold mb-1">Publikasi Resmi</span>
                    <h3 class="text-xl font-heading font-bold text-white">Buku Profil Desa Pebadaran (PDF)</h3>
                    <p class="text-sm text-cream/80 mt-1">Dapatkan informasi profil lengkap desa dalam satu dokumen PDF resmi (29 Halaman).</p>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                <button @click="activeTab = 'buku-profil'; window.scrollTo({top: 400, behavior: 'smooth'})" class="px-5 py-2.5 rounded-xl bg-gold hover:bg-gold-dark text-navy-900 font-semibold text-sm transition-all duration-200 shadow-md">
                    Lihat & Baca Buku
                </button>
                <a href="{{ asset('bukuProfile.pdf') }}" download="Buku_Profil_Desa_Pebadaran.pdf" class="px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-medium text-sm transition-all duration-200 border border-white/20">
                    Unduh PDF
                </a>
            </div>
        </div>

    </div>

    <!-- PDF Fullscreen Modal -->
    <div x-show="showPdfModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-navy-900/80 backdrop-blur-md"
         @keydown.escape.window="showPdfModal = false"
         style="display: none;">
         
        <div class="absolute inset-0" @click="showPdfModal = false"></div>
        
        <div class="relative w-full max-w-6xl h-[90vh] bg-white rounded-2xl overflow-hidden shadow-2xl flex flex-col z-10 border border-gold/30">
            <div class="bg-navy-900 text-white px-6 py-4 flex items-center justify-between border-b border-gold/20">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-gold"></span>
                    <h3 class="font-heading font-semibold text-lg text-white">Buku Profil Desa Pebadaran - Mode Layar Penuh</h3>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ asset('bukuProfile.pdf') }}" download class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-gold text-navy-900 hover:bg-gold-dark transition">Unduh PDF</a>
                    <button @click="showPdfModal = false" class="text-white/70 hover:text-white transition p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
            <div class="flex-grow w-full bg-gray-900">
                <iframe src="{{ asset('bukuProfile.pdf') }}" class="w-full h-full border-0"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection
