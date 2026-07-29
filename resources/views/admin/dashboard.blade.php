@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}!</h2>
    <p class="text-gray-600">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="rounded-full bg-blue-100 p-3 mr-4">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Penduduk</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['totalPenduduk'] ?? 0 }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="rounded-full bg-indigo-100 p-3 mr-4">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total KK</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['totalKK'] ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="rounded-full bg-cyan-100 p-3 mr-4">
            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Laki-laki</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['lakiLaki'] ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="rounded-full bg-pink-100 p-3 mr-4">
            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Perempuan</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['perempuan'] ?? 0 }}</p>
        </div>
    </div>

</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Gender</h3>
        <div class="h-64 relative">
            <canvas id="genderChart"></canvas>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kelompok Umur</h3>
        <div class="h-64 relative">
            <canvas id="ageChart"></canvas>
        </div>
    </div>

</div>

<!-- Recent Activity Row -->
<div class="grid grid-cols-1 gap-6">
    <!-- Latest Berita -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Berita Terbaru</h3>
            <a href="{{ route('admin.berita.index') }}" class="text-sm text-[#2E5090] hover:underline">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse($stats['latestBerita'] ?? [] as $berita)
            <div class="flex items-center gap-4 border-b pb-3 last:border-0 last:pb-0">
                <div class="w-16 h-16 rounded bg-gray-100 flex-shrink-0 overflow-hidden">
                    @if($berita->thumbnail)
                        <img src="{{ Storage::url($berita->thumbnail) }}" alt="Thumbnail" class="w-full h-full object-cover">
                    @else
                        <svg class="w-8 h-8 m-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    @endif
                </div>
                <div>
                    <h4 class="font-medium text-gray-800 line-clamp-1">{{ $berita->judul }}</h4>
                    <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($berita->created_at)->format('d/m/Y H:i') }} • 
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $berita->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $berita->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-gray-500">Belum ada berita</div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data from backend
    const statsData = @json($stats ?? []);
    
    // 1. Gender Chart (Pie)
    const ctxGender = document.getElementById('genderChart');
    if (ctxGender) {
        new Chart(ctxGender, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [statsData.lakiLaki || 0, statsData.perempuan || 0],
                    backgroundColor: ['#2E5090', '#EC4899'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '70%'
            }
        });
    }

    // 2. Age Group Chart (Bar)
    const ctxAge = document.getElementById('ageChart');
    if (ctxAge) {
        const ageLabels = Object.keys(statsData.ageGroups || {});
        const ageValues = Object.values(statsData.ageGroups || {});
        
        new Chart(ctxAge, {
            type: 'bar',
            data: {
                labels: ageLabels.length ? ageLabels : ['Anak', 'Remaja', 'Dewasa', 'Lansia'],
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: ageValues.length ? ageValues : [0, 0, 0, 0],
                    backgroundColor: '#1E3058',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });
    }

});
</script>
