@extends('layouts.admin')

@section('title', 'Visi & Misi')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Visi & Misi Desa</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-4xl" x-data="visiMisiManager()">
    <form action="{{ route('admin.pengaturan.visi-misi.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Visi -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
                <div class="w-8 h-8 rounded bg-blue-100 text-blue-700 flex items-center justify-center mr-2">V</div>
                Visi Desa
            </h3>
            <div class="pl-10">
                <textarea name="visi" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] text-lg font-medium" placeholder="Tuliskan Visi Desa di sini..." required>{{ $visi->konten ?? '' }}</textarea>
            </div>
        </div>

        <!-- Misi -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <div class="w-8 h-8 rounded bg-green-100 text-green-700 flex items-center justify-center mr-2">M</div>
                    Misi Desa
                </h3>
                <button type="button" @click="addMisi()" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-800 py-1.5 px-3 rounded-lg font-medium flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Misi
                </button>
            </div>
            
            <div class="pl-10 space-y-3" id="misi-container">
                <template x-for="(m, index) in misiList" :key="index">
                    <div class="flex gap-2 items-start">
                        <div class="bg-gray-100 w-8 h-10 rounded flex items-center justify-center font-bold text-gray-500 shrink-0" x-text="index + 1"></div>
                        <input type="text" :name="'misi['+index+']'" x-model="m.konten" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090]" placeholder="Tuliskan misi...">
                        <button type="button" @click="removeMisi(index)" class="w-10 h-10 rounded-lg text-red-500 hover:bg-red-50 flex items-center justify-center shrink-0 border border-transparent hover:border-red-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </template>
                
                <div x-show="misiList.length === 0" class="text-center py-4 text-gray-500 italic bg-gray-50 rounded-lg border border-dashed border-gray-300">
                    Belum ada misi. Klik "Tambah Misi" untuk mulai menambahkan.
                </div>
            </div>
        </div>

        <div class="pt-4 border-t flex justify-end">
            <button type="submit" class="bg-[#2E5090] text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-[#1f3661] transition-colors shadow-sm">Simpan Visi & Misi</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('visiMisiManager', () => ({
            misiList: @json($misi->map(fn($m) => ['konten' => $m->konten])->toArray() ?? [['konten' => '']]),
            
            addMisi() {
                this.misiList.push({ konten: '' });
            },
            
            removeMisi(index) {
                this.misiList.splice(index, 1);
            }
        }))
    })
</script>
@endsection
