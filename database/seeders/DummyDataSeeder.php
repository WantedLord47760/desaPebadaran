<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Umkm;
use App\Models\Kukerta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Download or prepare dummy images
        $this->prepareImages();

        // 2. Seed Berita
        $this->seedBerita();

        // 3. Seed Galeri
        $this->seedGaleri();

        // 4. Seed UMKM
        $this->seedUmkm();

        // 5. Seed Kukerta
        $this->seedKukerta();
    }

    private function prepareImages(): void
    {
        $directories = ['berita', 'galeri', 'umkm', 'kukerta'];
        foreach ($directories as $dir) {
            $path = storage_path('app/public/' . $dir);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
        }

        // Image map from Unsplash
        $images = [
            'berita/berita_1.jpg' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?w=800&auto=format&fit=crop&q=80',
            'berita/berita_2.jpg' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=800&auto=format&fit=crop&q=80',
            'berita/berita_3.jpg' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=800&auto=format&fit=crop&q=80',
            'berita/berita_4.jpg' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=800&auto=format&fit=crop&q=80',
            'berita/berita_5.jpg' => 'https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=800&auto=format&fit=crop&q=80',

            'galeri/galeri_1.jpg' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&auto=format&fit=crop&q=80',
            'galeri/galeri_2.jpg' => 'https://images.unsplash.com/photo-1596236813350-df6f59b5c0c1?w=800&auto=format&fit=crop&q=80',
            'galeri/galeri_3.jpg' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=800&auto=format&fit=crop&q=80',
            'galeri/galeri_4.jpg' => 'https://images.unsplash.com/photo-1516253593875-bd7ba052fbc5?w=800&auto=format&fit=crop&q=80',
            'galeri/galeri_5.jpg' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&auto=format&fit=crop&q=80',
            'galeri/galeri_6.jpg' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=800&auto=format&fit=crop&q=80',

            'umkm/umkm_1.jpg' => 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=800&auto=format&fit=crop&q=80',
            'umkm/umkm_2.jpg' => 'https://images.unsplash.com/photo-1608198093002-ad4e005484ec?w=800&auto=format&fit=crop&q=80',
            'umkm/umkm_3.jpg' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800&auto=format&fit=crop&q=80',
            'umkm/umkm_4.jpg' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800&auto=format&fit=crop&q=80',
            'umkm/umkm_5.jpg' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?w=800&auto=format&fit=crop&q=80',

            'kukerta/kukerta_1.jpg' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&auto=format&fit=crop&q=80',
            'kukerta/kukerta_1_d1.jpg' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&auto=format&fit=crop&q=80',
            'kukerta/kukerta_1_d2.jpg' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=800&auto=format&fit=crop&q=80',
            'kukerta/kukerta_2.jpg' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&auto=format&fit=crop&q=80',
            'kukerta/kukerta_3.jpg' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800&auto=format&fit=crop&q=80',
            'kukerta/kukerta_4.jpg' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=800&auto=format&fit=crop&q=80',
            'kukerta/kukerta_5.jpg' => 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?w=800&auto=format&fit=crop&q=80',
        ];

        $opts = ['http' => ['header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"]];
        $context = stream_context_create($opts);

        foreach ($images as $relativeFilePath => $url) {
            $fullPath = storage_path('app/public/' . $relativeFilePath);
            if (!file_exists($fullPath) || filesize($fullPath) < 1000) {
                $content = @file_get_contents($url, false, $context);
                if ($content) {
                    file_put_contents($fullPath, $content);
                } else {
                    // Fallback: create placeholder color SVG converted to file or simple placeholder image
                    $this->createFallbackImage($fullPath, pathinfo($relativeFilePath, PATHINFO_FILENAME));
                }
            }
        }
    }

    private function createFallbackImage(string $filePath, string $text): void
    {
        if (extension_loaded('gd')) {
            $img = imagecreatetruecolor(800, 500);
            $bgColor = imagecolorallocate($img, 46, 80, 144); // Navy blue
            $textColor = imagecolorallocate($img, 255, 255, 255);
            imagefill($img, 0, 0, $bgColor);
            imagestring($img, 5, 300, 240, $text, $textColor);
            imagejpeg($img, $filePath, 85);
            imagedestroy($img);
        }
    }

    private function seedBerita(): void
    {
        Berita::truncate();

        $beritaList = [
            [
                'judul' => 'Musrenbang Desa Pebadaran 2026: Prioritaskan Pembangunan Infrastruktur dan Ekonomi Kreatif',
                'slug' => 'musrenbang-desa-pebadaran-2026',
                'kategori' => 'Kegiatan',
                'thumbnail' => 'berita/berita_1.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'konten' => '
                    <h2 class="text-2xl font-bold text-navy-900 mb-4">Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes)</h2>
                    <p class="mb-4">Pemerintah Desa Pebadaran menyelenggarakan Musrenbangdes dalam rangka menyusun Rencana Kerja Pemerintah Desa (RKPDes) Tahun Anggaran 2026. Acara dihadiri oleh Kepala Desa, Perangkat Desa, Badan Permusyawaratan Desa (BPD), Tokoh Masyarakat, Perwakilan Perempuan, serta Tim Mahasiswa KKN / KUKERTA.</p>
                    
                    <h3 class="text-xl font-semibold text-navy-800 mt-6 mb-3">Program Prioritas Tahun 2026</h3>
                    <ul class="list-disc pl-6 mb-4 space-y-2">
                        <li><strong>Peningkatan Jalan Usaha Tani:</strong> Pengaspalan dan semenisasi jalan produksi pertanian untuk mempermudah distribusi hasil panen warga.</li>
                        <li><strong>Pengembangan UMKM Khas Desa:</strong> Pelatihan branding, sertifikasi halal, dan pemasaran digital bagi produk lokal.</li>
                        <li><strong>Digitalisasi Pelayanan Desa:</strong> Optimalisasi portal resmi web Desa Pebadaran untuk pelayanan administrasi warga.</li>
                        <li><strong>Program Kesehatan Ibu & Anak:</strong> Revitalisasi sarana Posyandu dan pencegahan stunting terpadu.</li>
                    </ul>

                    <blockquote class="p-4 my-4 border-s-4 border-navy-900 bg-navy-50 text-navy-900 italic font-medium rounded-e-lg">
                        "Melalui Musrenbangdes ini, seluruh aspirasi warga dari tiap RT/RW ditampung dan diprioritaskan secara transparan demi kemajuan bersama Desa Pebadaran."
                        <span class="block mt-2 font-bold not-italic text-sm text-navy-700">— Kepala Desa Pebadaran</span>
                    </blockquote>

                    <p>Acara ditutup dengan penandatanganan Berita Acara Kesepakatan Musrenbangdes 2026 oleh Kepala Desa dan Ketua BPD Pebadaran.</p>
                '
            ],
            [
                'judul' => 'Penyaluran Bantuan Langsung Tunai (BLT) Dana Desa Tahap II Berjalan Tertib dan Transparan',
                'slug' => 'penyaluran-blt-dana-desa-tahap-ii',
                'kategori' => 'Pengumuman',
                'thumbnail' => 'berita/berita_2.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'konten' => '
                    <h2 class="text-2xl font-bold text-navy-900 mb-4">Penyaluran BLT Dana Desa Bagi KPM Terdata</h2>
                    <p class="mb-4">Pemerintah Desa Pebadaran secara resmi menyerahkan Bantuan Langsung Tunai (BLT) Dana Desa Tahap II kepada Keluarga Penerima Manfaat (KPM). Penyerahan bantuan ini dilaksanakan di Aula Kantor Desa Pebadaran dengan menerapkan standar transparansi publik.</p>
                    
                    <h3 class="text-xl font-semibold text-navy-800 mt-6 mb-3">Detail Penyaluran Bantuan</h3>
                    <p class="mb-4">Sebanyak 45 KPM menerima bantuan uang tunai senilai Rp 300.000,- per bulan. Penentuan KPM ini telah melalui proses verifikasi lapangan dan Musyawarah Desa Khusus (Musdesus) agar tepat sasaran.</p>

                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-4">
                        <h4 class="font-bold text-navy-900 mb-1">Informasi Pengambilan Bantuan:</h4>
                        <p class="text-sm text-navy-800">Bagi KPM yang berhalangan hadir karena sakit atau usia lanjut, petugas dari Pemerintah Desa akan melakukan kunjungan langsung (door-to-door) ke rumah penerima.</p>
                    </div>
                '
            ],
            [
                'judul' => 'Gotong Royong Massal Bersama Mahasiswa KKN Bersihkan Lingkungan Desa Pebadaran',
                'slug' => 'gotong-royong-massal-bersama-mahasiswa-kkn',
                'kategori' => 'Kegiatan',
                'thumbnail' => 'berita/berita_3.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(8),
                'konten' => '
                    <h2 class="text-2xl font-bold text-navy-900 mb-4">Semangat Kebersamaan dalam Aksi Clean Up Desa</h2>
                    <p class="mb-4">Masyarakat Desa Pebadaran bersama tim mahasiswa Kuliah Kerja Nyata (KUKERTA) menggelar kegiatan gotong royong massal di sepanjang jalan utama desa, area tempat ibadah, dan fasilitas umum.</p>

                    <h3 class="text-xl font-semibold text-navy-800 mt-6 mb-3">Fokus Kegiatan Gotong Royong:</h3>
                    <ol class="list-decimal pl-6 mb-4 space-y-2">
                        <li>Pembersihan drainase untuk mencegah genangan air saat musim hujan.</li>
                        <li>Pemangkasan ranting pohon yang berpotensi membahayakan pengguna jalan.</li>
                        <li>Pengecatan dan pembenahan gapura batas desa.</li>
                        <li>Pemasangan tempat sampah organik dan anorganik di fasilitas umum.</li>
                    </ol>

                    <p>Kegiatan ini disambut antusias oleh warga dari berbagai usia, mencerminkan nilai budaya gotong royong yang masih terjaga erat di Desa Pebadaran.</p>
                '
            ],
            [
                'judul' => 'Pelatihan Digital Marketing dan Packaging Kreatif untuk Pelaku UMKM Lokal Pebadaran',
                'slug' => 'pelatihan-digital-marketing-umkm-pebadaran',
                'kategori' => 'Berita',
                'thumbnail' => 'berita/berita_4.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(12),
                'konten' => '
                    <h2 class="text-2xl font-bold text-navy-900 mb-4">Mendorong UMKM Desa Pebadaran Go Digital</h2>
                    <p class="mb-4">Untuk meningkatkan daya saing produk lokal, Pemerintah Desa Pebadaran bekerja sama dengan praktisi pemasaran digital menyelenggarakan Workshop Digital Marketing & Redesign Kemasan Produk UMKM Desa.</p>

                    <h3 class="text-xl font-semibold text-navy-800 mt-6 mb-3">Materi yang Disampaikan</h3>
                    <ul class="list-disc pl-6 mb-4 space-y-2">
                        <li>Fotografi produk menggunakan smartphone.</li>
                        <li>Pembuatan label dan logo produk berbantu aplikasi desain modern.</li>
                        <li>Strategi pemasaran melalui WhatsApp Business dan Media Sosial.</li>
                        <li>Pencatatan keuangan sederhana bagi pelaku usaha mikro.</li>
                    </ul>

                    <p>Diharapkan produk khas Desa Pebadaran seperti keripik pisang, madu hutan, dan olahan kerupuk dapat menjangkau pasar yang lebih luas hingga tingkat nasional.</p>
                '
            ],
            [
                'judul' => 'Pengumuman Pelayanan Kesehatan Posyandu Balita dan Lansia Rutin Bulan Ini',
                'slug' => 'pengumuman-pelayanan-posyandu-rutin',
                'kategori' => 'Pengumuman',
                'thumbnail' => 'berita/berita_5.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(15),
                'konten' => '
                    <h2 class="text-2xl font-bold text-navy-900 mb-4">Jadwal Pelayanan Posyandu Melati Desa Pebadaran</h2>
                    <p class="mb-4">Diberitahukan kepada seluruh warga Desa Pebadaran, khususnya ibu hamil, ibu menyusui, balita, serta para lansia, bahwa kegiatan Posyandu rutin akan dilaksanakan dengan jadwal sebagai berikut:</p>

                    <div class="bg-gray-50 border-l-4 border-navy-900 p-4 mb-4">
                        <p class="font-bold text-navy-900"> Hari / Tanggal: Sabtu, 02 Agustus 2026</p>
                        <p class="font-bold text-navy-900"> Waktu: 08.00 WIB s/d Selesai</p>
                        <p class="font-bold text-navy-900"> Tempat: Gedung Posyandu Melati Desa Pebadaran</p>
                    </div>

                    <h3 class="text-xl font-semibold text-navy-800 mt-6 mb-3">Layanan yang Disediakan:</h3>
                    <ul class="list-disc pl-6 mb-4 space-y-1">
                        <li>Penimbangan BB dan pengukuran TB Balita</li>
                        <li>Imunisasi dasar lengkap dan vitamin A</li>
                        <li>Pemeriksaan tekanan darah dan gula darah lansia</li>
                        <li>Konsultasi gizi gratis dan pemberian PMT (Pemberian Makanan Tambahan)</li>
                    </ul>
                '
            ]
        ];

        foreach ($beritaList as $data) {
            Berita::create($data);
        }
    }

    private function seedGaleri(): void
    {
        Galeri::truncate();

        $galeriList = [
            [
                'judul' => 'Pemandangan Persawahan Hijau Khas Desa Pebadaran',
                'file_path' => 'galeri/galeri_1.jpg',
                'tipe' => 'foto',
                'deskripsi' => 'Panorama keindahan alam persawahan yang subur di wilayah Desa Pebadaran saat pagi hari.',
                'urutan' => 1,
            ],
            [
                'judul' => 'Kegiatan Posyandu Balita dan Lansia Desa',
                'file_path' => 'galeri/galeri_2.jpg',
                'tipe' => 'foto',
                'deskripsi' => 'Dokumentasi penimbangan dan pemberian makanan tambahan di Posyandu Melati Pebadaran.',
                'urutan' => 2,
            ],
            [
                'judul' => 'Aksi Gotong Royong Kebersihan Desa Pebadaran',
                'file_path' => 'galeri/galeri_3.jpg',
                'tipe' => 'foto',
                'deskripsi' => 'Masyarakat bersama aparat desa dan mahasiswa KUKERTA bahu membahu membersihkan lingkungan.',
                'urutan' => 3,
            ],
            [
                'judul' => 'Bimbingan Belajar dan Kreativitas Anak Desa',
                'file_path' => 'galeri/galeri_4.jpg',
                'tipe' => 'foto',
                'deskripsi' => 'Kegiatan belajar mengajar ceria bersama anak-anak di Saung Baca Desa Pebadaran.',
                'urutan' => 4,
            ],
            [
                'judul' => 'Pelatihan Pembuatan Kerajinan Tangan Anyaman',
                'file_path' => 'galeri/galeri_5.jpg',
                'tipe' => 'foto',
                'deskripsi' => 'Suasana pelatihan keterampilan kerajinan tangan lokal untuk pemberdayaan perempuan desa.',
                'urutan' => 5,
            ],
            [
                'judul' => 'Musyawarah Perencanaan Desa (Musrenbang)',
                'file_path' => 'galeri/galeri_6.jpg',
                'tipe' => 'foto',
                'deskripsi' => 'Dokumentasi diskusi dan perumusan RKPDes bersama tokoh masyarakat Pebadaran.',
                'urutan' => 6,
            ],
        ];

        foreach ($galeriList as $data) {
            Galeri::create($data);
        }
    }

    private function seedUmkm(): void
    {
        Umkm::truncate();

        $umkmList = [
            [
                'nama_produk' => 'Keripik Pisang Renyah Khas Pebadaran',
                'deskripsi' => 'Keripik pisang pilihan hasil kebun lokal Desa Pebadaran dengan aneka varian rasa (Original, Cokelat, Balado, Keju). Diolah higienis tanpa bahan pengawet.',
                'harga' => 15000,
                'foto' => 'umkm/umkm_1.jpg',
                'nama_penjual' => 'Ibu Nurhayati (Kelompok Tani Wanita)',
                'no_whatsapp' => '081234567891',
                'kategori' => 'Makanan',
                'is_active' => true,
            ],
            [
                'nama_produk' => 'Madu Hutan Murni Pebadaran 500ml',
                'deskripsi' => 'Madu asli yang dipanen langsung dari hutan sekitar Desa Pebadaran. Kaya akan vitamin, mineral, dan daya tahan tubuh. 100% alami tanpa campuran gula.',
                'harga' => 85000,
                'foto' => 'umkm/umkm_2.jpg',
                'nama_penjual' => 'Pak Sutrisno',
                'no_whatsapp' => '081234567892',
                'kategori' => 'Minuman',
                'is_active' => true,
            ],
            [
                'nama_produk' => 'Kerajinan Anyaman Bambu Tradisional',
                'deskripsi' => 'Tas anyaman, tempat buah, dan wadah serbaguna yang dibuat secara manual dengan ketelitian tinggi oleh para pengrajin lokal Desa Pebadaran.',
                'harga' => 45000,
                'foto' => 'umkm/umkm_3.jpg',
                'nama_penjual' => 'Pak Slamet',
                'no_whatsapp' => '081234567893',
                'kategori' => 'Kerajinan',
                'is_active' => true,
            ],
            [
                'nama_produk' => 'Kopi Robusta Asli Desa Pebadaran 250g',
                'deskripsi' => 'Biji kopi pilihan yang disangrai secara tradisional menghasilkan aroma khas yang kuat dan rasa gurih alami. Sangat cocok untuk penikmat kopi sejati.',
                'harga' => 35000,
                'foto' => 'umkm/umkm_4.jpg',
                'nama_penjual' => 'Kelompok Tani Kopi Pebadaran',
                'no_whatsapp' => '081234567894',
                'kategori' => 'Minuman',
                'is_active' => true,
            ],
            [
                'nama_produk' => 'Kerupuk Ikan River Fresh Pebadaran',
                'deskripsi' => 'Kerupuk renyah terbuat dari daging ikan segar tangkapan sungai lokal Desa Pebadaran dipadu bumbu rempah tradisional yang lezat.',
                'harga' => 20000,
                'foto' => 'umkm/umkm_5.jpg',
                'nama_penjual' => 'Ibu Halimah',
                'no_whatsapp' => '081234567895',
                'kategori' => 'Makanan',
                'is_active' => true,
            ],
        ];

        foreach ($umkmList as $data) {
            Umkm::create($data);
        }
    }

    private function seedKukerta(): void
    {
        Kukerta::truncate();

        $kukertaList = [
            [
                'judul' => 'Bimbingan Belajar Ceria: Pemberdayaan Masyarakat Melalui Pendidikan Anak Desa Pebadaran',
                'slug' => 'bimbingan-belajar-ceria-pemberdayaan-masyarakat-melalui-pendidikan-anak-desa-pebadaran',
                'kategori' => 'Pendidikan',
                'thumbnail' => 'kukerta/prokerBimbel/bimbel_thumb.jpeg',
                'foto_dokumentasi' => [
                    'kukerta/prokerBimbel/bimbel_doc_1.jpeg',
                    'kukerta/prokerBimbel/bimbel_doc_2.jpeg',
                    'kukerta/prokerBimbel/bimbel_doc_3.jpeg',
                    'kukerta/prokerBimbel/bimbel_doc_4.jpeg',
                    'kukerta/prokerBimbel/bimbel_doc_5.jpeg'
                ],
                'status' => 'Selesai',
                'tanggal_mulai' => '2026-07-04',
                'tanggal_selesai' => '2026-08-20',
                'is_published' => true,
                'published_at' => now(),
                'pelaksana' => [
                    ['nama' => 'SOFIA ARIFAH', 'nim' => '2305126938', 'universitas' => 'Pendidikan Bahasa Inggris - FKIP'],
                    ['nama' => 'PUTRI AMALIA', 'nim' => '2304135528', 'universitas' => 'Teknologi Hasil Perikanan - FAPERIKA'],
                    ['nama' => 'TENGKU RISYA DWI JULIETHA', 'nim' => '2302113997', 'universitas' => 'Akuntansi - FEB'],
                    ['nama' => 'HILMI AMINUDDIEN', 'nim' => '2307112162', 'universitas' => 'Teknik Informatika - FT'],
                ],
                'konten' => '
                    <div class="space-y-6 text-navy-900">
                        <!-- Card Banner Ringkasan Program -->
                        <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-5 sm:p-6 text-navy-900">
                            <div class="flex items-center gap-2 text-royal font-bold text-xs sm:text-sm uppercase tracking-wider mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                Program Kerja No. 3 — KUKERTA Desa Pebadaran
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-navy-900 mb-2">Program Bimbingan Belajar (Bimbel) Ceria</h3>
                            <p class="text-navy-800 text-sm sm:text-base leading-relaxed mb-4">
                                Program Bimbingan Belajar dirancang untuk meningkatkan kemampuan akademik serta menumbuhkan minat belajar anak-anak Sekolah Dasar (SD/MI) Kampung Pebadaran melalui metode interaktif, kondusif, dan menyenangkan.
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3 border-t border-blue-200/70">
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Bidang</span>
                                    <span class="text-sm font-bold text-navy-900">Pemberdayaan Pendidikan</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Pelaksanaan</span>
                                    <span class="text-sm font-bold text-navy-900">4 Juli 2026</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Lokasi</span>
                                    <span class="text-sm font-bold text-navy-900">PEBADARAN</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Target</span>
                                    <span class="text-sm font-bold text-navy-900">Anak SD / MI</span>
                                </div>
                            </div>
                        </div>

                        <!-- Latar Belakang & Tujuan -->
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-navy-900 mb-3">Latar Belakang & Tujuan Program</h2>
                            <p class="text-gray-700 text-base leading-relaxed mb-3">
                                Pendidikan tingkat sekolah dasar merupakan masa penting pembentukan karakter dan pemahaman konsep dasar anak. Dalam rangka mendukung peningkatan mutu pendidikan di Desa Pebadaran, tim pelaksana menginisiasi kegiatan <strong>Bimbingan Belajar (Bimbel) Ceria</strong>.
                            </p>
                            <p class="text-gray-700 text-base leading-relaxed">
                                Program ini berfokus pada pendampingan materi pelajaran sekolah, khususnya mata pelajaran <strong>Matematika</strong> dan <strong>Bahasa Inggris</strong>, agar anak-anak dapat memahami materi dengan lebih baik dan percaya diri.
                            </p>
                        </div>

                        <!-- Target & Indikator Keberhasilan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
                            <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">🎯 Target Peserta</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Sasaran program ini adalah seluruh anak-anak Kampung Pebadaran tingkat <strong>SD/MI</strong>.
                                </p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">📊 Indikator Keberhasilan</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Kehadiran peserta minimal <strong>15 anak per sesi</strong> dan adanya peningkatan pemahaman materi setelah evaluasi.
                                </p>
                            </div>
                        </div>

                        <!-- Fokus Pembelajaran -->
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-navy-900 mb-4">Fokus Pembelajaran Utama</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="p-4 bg-white border border-gray-200 rounded-xl">
                                    <h3 class="text-base font-bold text-navy-900 mb-2">📐 Matematika Dasar & Logika</h3>
                                    <ul class="text-sm text-gray-700 space-y-1.5 list-disc pl-5">
                                        <li>Penguatan operasi hitung dasar (penjumlahan, pengurangan, perkalian, pembagian).</li>
                                        <li>Metode berhitung cepat dan menyenangkan.</li>
                                        <li>Pendampingan penyelesaian Tugas Sekolah (PR).</li>
                                    </ul>
                                </div>

                                <div class="p-4 bg-white border border-gray-200 rounded-xl">
                                    <h3 class="text-base font-bold text-navy-900 mb-2">🔤 Basic English & Conversation</h3>
                                    <ul class="text-sm text-gray-700 space-y-1.5 list-disc pl-5">
                                        <li>Pengenalan kosakata (vocabularies) benda sekitar, angka, dan hewan.</li>
                                        <li>Latihan percakapan sederhana dan pengucapan (pronunciation).</li>
                                        <li>Permainan kartu edukatif (flashcard) & lagu Bahasa Inggris.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Dampak Program -->
                        <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl text-navy-900">
                            <h3 class="text-base font-bold text-navy-900 mb-2">Dampak & Manfaat Program</h3>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                Meningkatnya kemampuan Matematika dan Bahasa Inggris siswa SD Desa Pebadaran, bertambahnya kepercayaan diri anak-anak saat belajar di kelas, serta terciptanya budaya belajar kelompok yang positif di lingkungan masyarakat.
                            </p>
                        </div>
                    </div>
                '
            ],
            [
                'judul' => 'Pengembangan Website Profil & Sistem Informasi Digital Desa Pebadaran',
                'slug' => 'pengembangan-website-profil-sistem-informasi-digital-desa-pebadaran',
                'kategori' => 'Teknologi',
                'thumbnail' => 'kukerta/kukerta_1.jpg',
                'foto_dokumentasi' => ['kukerta/kukerta_1_d1.jpg', 'kukerta/kukerta_1_d2.jpg'],
                'status' => 'Selesai',
                'tanggal_mulai' => '2026-07-01',
                'tanggal_selesai' => '2026-08-15',
                'is_published' => true,
                'published_at' => now()->subDays(1),
                'pelaksana' => [
                    ['nama' => 'Rizky Ramadhan', 'nim' => '2108101015', 'universitas' => 'Universitas Riau'],
                    ['nama' => 'Aisyah Putri', 'nim' => '2108101020', 'universitas' => 'Universitas Riau'],
                    ['nama' => 'Fajar Pratama', 'nim' => '2108101044', 'universitas' => 'Universitas Riau'],
                ],
                'konten' => '
                    <h2 class="text-2xl font-bold text-navy-900 mb-4">Latar Belakang & Tujuan Program Kerja</h2>
                    <p class="mb-4">Dalam era transformasi digital, keterbukaan informasi publik dan aksesibilitas data desa merupakan kebutuhan krusial. Tim KUKERTA Universitas Riau berinisiatif membangun website resmi Desa Pebadaran berbasis modern web framework Laravel.</p>

                    <h3 class="text-xl font-semibold text-navy-800 mt-6 mb-3">Fitur Utama Website Desa:</h3>
                    <ul class="list-disc pl-6 mb-4 space-y-2">
                        <li><strong>Modul Berita & Pengumuman:</strong> Memudahkan publikasi informasi terkini desa kepada warga.</li>
                        <li><strong>Katalog UMKM Desa:</strong> Membantu promosi produk lokal dengan tautan pemesanan langsung ke WhatsApp penjual.</li>
                        <li><strong>Galeri Kegiatan:</strong> Dokumentasi visual keindahan dan aktivitas warga desa.</li>
                        <li><strong>Portal KUKERTA / KKN:</strong> Transparansi laporan program kerja mahasiswa yang dilaksanakan di desa.</li>
                        <li><strong>Dashboard Admin:</strong> Pengelolaan data secara intuitif dan aman bagi perangkat desa.</li>
                    </ul>

                    <blockquote class="p-4 my-4 border-s-4 border-navy-900 bg-navy-50 text-navy-900 italic font-medium rounded-e-lg">
                        "Dengan adanya web desa ini, Desa Pebadaran siap menuju Desa Digital yang mandiri, informatif, dan transparan."
                    </blockquote>

                    <h3 class="text-xl font-semibold text-navy-800 mt-6 mb-3">Capaian & Dampak Program</h3>
                    <p class="mb-4">Sistem ini telah diserahterimakan secara resmi kepada Aparat Desa Pebadaran disertai sesi pelatihan pengelolaan data untuk admin desa.</p>
                '
            ],
            [
                'judul' => 'Penyuluhan Perilaku Hidup Bersih & Sehat (PHBS) serta Pengecekan Kesehatan Gratis',
                'slug' => 'penyuluhan-phbs-dan-pengecekan-kesehatan-gratis',
                'kategori' => 'Kesehatan',
                'thumbnail' => 'kukerta/kukerta_2.jpg',
                'foto_dokumentasi' => ['kukerta/kukerta_2.jpg'],
                'status' => 'Selesai',
                'tanggal_mulai' => '2026-07-05',
                'tanggal_selesai' => '2026-07-20',
                'is_published' => true,
                'published_at' => now()->subDays(6),
                'pelaksana' => [
                    ['nama' => 'Nabila Salsabila', 'nim' => '2109102012', 'universitas' => 'Universitas Riau'],
                    ['nama' => 'Budi Santoso', 'nim' => '2109102055', 'universitas' => 'Universitas Riau'],
                ],
                'konten' => '
                    <h2 class="text-2xl font-bold text-navy-900 mb-4">Program Peningkatan Kesehatan Masyarakat</h2>
                    <p class="mb-4">Program kerja ini bertujuan meningkatkan kesadaran pentingnya cuci tangan pakai sabun (CTPS), pengelolaan air bersih, dan pemenuhan gizi seimbang bagi anak-anak sekolah dasar dan lansia.</p>

                    <h3 class="text-xl font-semibold text-navy-800 mt-6 mb-3">Rangkaian Kegiatan:</h3>
                    <ol class="list-decimal pl-6 mb-4 space-y-2">
                        <li>Edukasi CTPS 6 Langkah WHO di SD Negeri 01 Pebadaran.</li>
                        <li>Pemeriksaan gratis asam urat, gula darah, dan kolesterol bagi 80+ warga lansia.</li>
                        <li>Pembagian vitamin dan makanan tambahan bergizi.</li>
                    </ol>
                '
            ],
            [
                'judul' => 'Pemetaan Digital Wilayah RT/RW dan Pemasangan Plang Nama Jalan Desa Pebadaran',
                'slug' => 'pemetaan-digital-rt-rw-dan-pemasangan-plang-jalan',
                'kategori' => 'Infrastruktur',
                'thumbnail' => 'kukerta/kukerta_3.jpg',
                'foto_dokumentasi' => ['kukerta/kukerta_3.jpg'],
                'status' => 'Selesai',
                'tanggal_mulai' => '2026-07-10',
                'tanggal_selesai' => '2026-07-25',
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'pelaksana' => [
                    ['nama' => 'Hendra Setiawan', 'nim' => '2103103088', 'universitas' => 'Universitas Riau'],
                    ['nama' => 'Dina Mariana', 'nim' => '2103103099', 'universitas' => 'Universitas Riau'],
                ],
                'konten' => '
                    <h2 class="text-2xl font-bold text-navy-900 mb-4">Penataan Infrastruktur Penunjuk Arah Desa</h2>
                    <p class="mb-4">Dalam upaya mempermudah navigasi bagi pendatang serta pendataan tata ruang desa, tim KUKERTA melakukan pengukuran titik koordinat GPS dan pembuatan peta cetak skala besar.</p>

                    <h3 class="text-xl font-semibold text-navy-800 mt-6 mb-3">Hasil Kegiatan:</h3>
                    <ul class="list-disc pl-6 mb-4 space-y-2">
                        <li>Pemasangan 12 plang nama jalan dan lorong utama desa berbahan tahan cuaca.</li>
                        <li>Penyerahan Peta Administrasi Desa Pebadaran ukuran A0 berpigura untuk diletakkan di kantor desa.</li>
                    </ul>
                '
            ],
            [
                'judul' => 'Pemberdayaan UMKM Melalui Foto Produk Profesional dan Pendampingan WhatsApp Business',
                'slug' => 'pemberdayaan-umkm-foto-produk-profesional',
                'kategori' => 'Ekonomi',
                'thumbnail' => 'kukerta/kukerta_4.jpg',
                'foto_dokumentasi' => ['kukerta/kukerta_4.jpg'],
                'status' => 'Berjalan',
                'tanggal_mulai' => '2026-07-15',
                'tanggal_selesai' => '2026-08-20',
                'is_published' => true,
                'published_at' => now()->subDays(4),
                'pelaksana' => [
                    ['nama' => 'Siti Aminah', 'nim' => '2105104011', 'universitas' => 'Universitas Riau'],
                    ['nama' => 'Rahmat Hidayat', 'nim' => '2105104033', 'universitas' => 'Universitas Riau'],
                ],
                'konten' => '
                    <h2 class="text-2xl font-bold text-navy-900 mb-4">Meningkatkan Daya Tarik Visual Produk Desa</h2>
                    <p class="mb-4">Tim KUKERTA memfasilitasi sesi mini studio foto bagi pelaku UMKM di Desa Pebadaran untuk menghasilkan foto katalog berkualitas tinggi yang kini dipasang pada katalog web desa.</p>
                '
            ],
            [
                'judul' => 'Pelatihan Pembuatan Pupuk Organik Cair (POC) dari Limbah Rumah Tangga',
                'slug' => 'pelatihan-pembuatan-pupuk-organik-cair',
                'kategori' => 'Lingkungan',
                'thumbnail' => 'kukerta/kukerta_5.jpg',
                'foto_dokumentasi' => ['kukerta/kukerta_5.jpg'],
                'status' => 'Perencanaan',
                'tanggal_mulai' => '2026-08-01',
                'tanggal_selesai' => '2026-08-25',
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'pelaksana' => [
                    ['nama' => 'Andi Wijaya', 'nim' => '2106105077', 'universitas' => 'Universitas Riau'],
                ],
                'konten' => '
                    <h2 class="text-2xl font-bold text-navy-900 mb-4">Solusi Ramah Lingkungan untuk Pertanian Desa</h2>
                    <p class="mb-4">Program kerja ini direncanakan untuk memanfaatkan sampah sisa dapur dan sayuran menjadi pupuk cair alami yang kaya nutrisi bagi tanaman pertanian warga Pebadaran.</p>
                '
            ]
        ];

            [
                'judul' => 'Pembuatan Penanda Rumah Perangkat Desa & Papan Petunjuk Arah Wilayah Kampung Pebadaran',
                'slug' => 'pembuatan-penanda-rumah-perangkat-desa-dan-papan-petunjuk-arah-wilayah-kampung-pebadaran',
                'kategori' => 'Tata Kelola Pemerintahan',
                'thumbnail' => 'kukerta/plangRTdanPenandaJalan/thumbnail.jpeg',
                'foto_dokumentasi' => [
                    'kukerta/plangRTdanPenandaJalan/IMG-20260722-WA0002.jpg.jpeg',
                    'kukerta/plangRTdanPenandaJalan/IMG-20260725-WA0004(1).jpg.jpeg'
                ],
                'status' => 'Selesai',
                'tanggal_mulai' => '2026-07-18',
                'tanggal_selesai' => '2026-07-18',
                'is_published' => true,
                'published_at' => now(),
                'pelaksana' => [
                    ['nama' => 'TENGKU RISYA DWI JULIETHA', 'nim' => '2302113997', 'universitas' => 'Akuntansi - FEB'],
                    ['nama' => 'DIVA TRI RAMADANI', 'nim' => '2302112815', 'universitas' => 'Ekonomi Pembangunan - FEB'],
                    ['nama' => 'YURI MARISA', 'nim' => '2302111059', 'universitas' => 'Ekonomi Pembangunan - FEB'],
                    ['nama' => 'MUHAMMAD ABIDILLAH', 'nim' => '2307112117', 'universitas' => 'Teknik Informatika - FT'],
                    ['nama' => 'PUTRI AMALIA', 'nim' => '2304135528', 'universitas' => 'Teknologi Hasil Perikanan - FAPERIKA'],
                    ['nama' => 'SOFIA ARIFAH', 'nim' => '2305126938', 'universitas' => 'Pendidikan Bahasa Inggris - FKIP'],
                    ['nama' => 'DAFFA SHOHIBUL IKHSAN', 'nim' => '2306113726', 'universitas' => 'Agroteknologi - FP'],
                    ['nama' => 'M. SOHIBBAL', 'nim' => '2307135312', 'universitas' => 'Teknik Informatika - FT'],
                    ['nama' => 'HILMI AMINUDDIEN', 'nim' => '2307112162', 'universitas' => 'Teknik Informatika - FT'],
                    ['nama' => 'BEBY OKTAVIA', 'nim' => '2305111184', 'universitas' => 'Pendidikan Guru Sekolah Dasar - FKIP'],
                ],
                'konten' => '
                    <div class="space-y-6 text-navy-900">
                        <!-- Card Banner Ringkasan Program -->
                        <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-5 sm:p-6 text-navy-900">
                            <div class="flex items-center gap-2 text-royal font-bold text-xs sm:text-sm uppercase tracking-wider mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Program Kerja KUKERTA — Tata Kelola Pemerintahan Desa
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-navy-900 mb-2">Program Pembuatan Penanda Rumah Perangkat Desa & Petunjuk Arah Wilayah</h3>
                            <p class="text-navy-800 text-sm sm:text-base leading-relaxed mb-4">
                                Program kerja integratif yang bertujuan untuk meningkatkan penataan kelola administrasi pemerintahan desa serta memudahkan navigasi lokasi fasilitas umum bagi warga maupun pengunjung eksternal di Kampung Pebadaran.
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3 border-t border-blue-200/70">
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Bidang</span>
                                    <span class="text-sm font-bold text-navy-900">Tata Kelola Pemerintah</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Pelaksanaan</span>
                                    <span class="text-sm font-bold text-navy-900">18 Juli 2026</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Lokasi</span>
                                    <span class="text-sm font-bold text-navy-900">PEBADARAN</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Target</span>
                                    <span class="text-sm font-bold text-navy-900">Perangkat Desa & Warga</span>
                                </div>
                            </div>
                        </div>

                        <!-- Latar Belakang & Tujuan -->
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-navy-900 mb-3">Latar Belakang & Tujuan Program</h2>
                            <p class="text-gray-700 text-base leading-relaxed mb-3">
                                Kemudahan identifikasi tempat tinggal perangkat desa serta ketersediaan papan penunjuk arah fasilitas publik merupakan bagian penting dari efisiensi pelayanan masyarakat di Kampung Pebadaran. Oleh karena itu, Tim Mahasiswa KUKERTA menginisiasi dua sub-program fisik tata kelola desa secara bersamaan:
                            </p>
                            <ol class="text-gray-700 text-base leading-relaxed space-y-2 list-decimal pl-5">
                                <li><strong>Pembuatan Penanda Rumah RT/RW & Kepala Dusun:</strong> Pemasangan papan penanda identitas resmi di kediaman para perangkat desa agar masyarakat dan tamu dapat dengan mudah menemukan lokasi pelayanan administrasi.</li>
                                <li><strong>Pembuatan Papan Petunjuk Arah Wilayah:</strong> Pemasangan plang penunjuk lokasi strategis fasilitas umum desa seperti Kantor Kampung, KUA Pebadaran, Kantor Camat Pusako, SDN 04 Pebadaran, Masjid Raya, Wisata Mangrove, dan Puskesmas.</li>
                            </ol>
                        </div>

                        <!-- Sub-Program 1 & Sub-Program 2 Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">🏡 1. Penanda Rumah RT & Perangkat Desa</h3>
                                <p class="text-sm text-gray-700 leading-relaxed mb-2">
                                    <strong>Sasaran:</strong> Seluruh tokoh masyarakat / perangkat desa di Desa Pebadaran.
                                </p>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    <strong>Target Keberhasilan:</strong> 10 penanda rumah Ketua RT, Ketua RW, dan Kepala Dusun terpasang dengan baik.
                                </p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">🧭 2. Papan Petunjuk Arah Wilayah</h3>
                                <p class="text-sm text-gray-700 leading-relaxed mb-2">
                                    <strong>Sasaran:</strong> Warga desa dan pengunjung / tamu eksternal.
                                </p>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    <strong>Target Keberhasilan:</strong> Papan petunjuk arah terpasang mencakup lokasi Kantor Kampung, KUA, Kantor Camat Pusako, SDN 04, Masjid Raya, Mangrove, dan Puskesmas.
                                </p>
                            </div>
                        </div>

                        <!-- Dampak Program -->
                        <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl text-navy-900">
                            <h3 class="text-base font-bold text-navy-900 mb-2">Dampak & Manfaat Program</h3>
                            <ul class="text-sm text-gray-700 space-y-1.5 list-disc pl-5">
                                <li>Memudahkan warga dan pengunjung eksternal dalam menemukan lokasi kediaman perangkat desa untuk urusan pelayanan publik.</li>
                                <li>Meningkatkan kemudahan navigasi dan aksesibilitas wilayah menuju berbagai fasilitas publik di Desa Pebadaran.</li>
                            </ul>
                        </div>
                    </div>
                '
            ],

            [
                'judul' => 'Sosialisasi ke Sekolah Terkait PHBS (Pola Hidup Bersih Sehat) di SDN 04 Desa Pebadaran',
                'slug' => 'sosialisasi-ke-sekolah-terkait-phbs-pola-hidup-bersih-sehat-di-sdn-04-desa-pebadaran',
                'kategori' => 'Kesehatan Masyarakat',
                'thumbnail' => 'kukerta/phbs/thumbnail.jpeg',
                'foto_dokumentasi' => [
                    'kukerta/phbs/WhatsApp Image 2026-07-28 at 22.27.58.jpeg',
                    'kukerta/phbs/WhatsApp Image 2026-07-28 at 22.29.13.jpeg',
                    'kukerta/phbs/WhatsApp Image 2026-07-28 at 22.30.12.jpeg',
                    'kukerta/phbs/WhatsApp Image 2026-07-28 at 22.30.45.jpeg'
                ],
                'status' => 'Selesai',
                'tanggal_mulai' => '2026-07-21',
                'tanggal_selesai' => '2026-07-21',
                'is_published' => true,
                'published_at' => now(),
                'pelaksana' => [
                    ['nama' => 'TENGKU RISYA DWI JULIETHA', 'nim' => '2302113997', 'universitas' => 'Akuntansi - FEB'],
                    ['nama' => 'DIVA TRI RAMADANI', 'nim' => '2302112815', 'universitas' => 'Ekonomi Pembangunan - FEB'],
                    ['nama' => 'YURI MARISA', 'nim' => '2302111059', 'universitas' => 'Ekonomi Pembangunan - FEB'],
                    ['nama' => 'MUHAMMAD ABIDILLAH', 'nim' => '2307112117', 'universitas' => 'Teknik Informatika - FT'],
                    ['nama' => 'PUTRI AMALIA', 'nim' => '2304135528', 'universitas' => 'Teknologi Hasil Perikanan - FAPERIKA'],
                    ['nama' => 'SOFIA ARIFAH', 'nim' => '2305126938', 'universitas' => 'Pendidikan Bahasa Inggris - FKIP'],
                    ['nama' => 'DAFFA SHOHIBUL IKHSAN', 'nim' => '2306113726', 'universitas' => 'Agroteknologi - FP'],
                    ['nama' => 'M. SOHIBBAL', 'nim' => '2307135312', 'universitas' => 'Teknik Informatika - FT'],
                    ['nama' => 'HILMI AMINUDDIEN', 'nim' => '2307112162', 'universitas' => 'Teknik Informatika - FT'],
                    ['nama' => 'BEBY OKTAVIA', 'nim' => '2305111184', 'universitas' => 'Pendidikan Guru Sekolah Dasar - FKIP'],
                ],
                'konten' => '
                    <div class="space-y-6 text-navy-900">
                        <!-- Card Banner Ringkasan Program -->
                        <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-5 sm:p-6 text-navy-900">
                            <div class="flex items-center gap-2 text-royal font-bold text-xs sm:text-sm uppercase tracking-wider mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                Program Kerja KUKERTA — Kesehatan Masyarakat & Gizi Seimbang
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-navy-900 mb-2">Sosialisasi Pola Hidup Bersih Sehat (PHBS) di Sekolah</h3>
                            <p class="text-navy-800 text-sm sm:text-base leading-relaxed mb-4">
                                Kegiatan edukasi kesehatan yang dirancang untuk membangun kesadaran serta kebiasaan hidup bersih dan sehat sejak dini bagi seluruh murid di SDN 04 Desa Pebadaran melalui metode edukatif yang interaktif dan menyenangkan.
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3 border-t border-blue-200/70">
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Bidang</span>
                                    <span class="text-sm font-bold text-navy-900">Kesehatan Masyarakat</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Pelaksanaan</span>
                                    <span class="text-sm font-bold text-navy-900">21 Juli 2026</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Lokasi</span>
                                    <span class="text-sm font-bold text-navy-900">SDN 04 PEBADARAN</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Target</span>
                                    <span class="text-sm font-bold text-navy-900">Siswa SDN 04</span>
                                </div>
                            </div>
                        </div>

                        <!-- Latar Belakang & Tujuan -->
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-navy-900 mb-3">Latar Belakang & Tujuan Program</h2>
                            <p class="text-gray-700 text-base leading-relaxed mb-3">
                                Pola Hidup Bersih dan Sehat (PHBS) merupakan pondasi penting dalam menjaga kesehatan dan mendukung tumbuh kembang anak-anak usia sekolah. Dalam rangka mengedukasi siswa-siswi sekolah dasar di Desa Pebadaran, Tim Mahasiswa KUKERTA menyelenggarakan program <strong>Sosialisasi PHBS & Edukasi Gizi Seimbang</strong> di SDN 04 Desa Pebadaran.
                            </p>
                            <p class="text-gray-700 text-base leading-relaxed">
                                Program ini bertujuan untuk memberikan pemahaman praktis mengenai tata cara menjaga kebersihan diri, pencegahan penyakit, serta pentingnya mengonsumsi makanan bergizi seimbang sesuai panduan kesehatan nasional.
                            </p>
                        </div>

                        <!-- Target & Indikator Keberhasilan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">🎯 Target Peserta</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Sasaran program ini adalah <strong>seluruh siswa-siswi SDN 04 Desa Pebadaran</strong> dari berbagai tingkatan kelas.
                                </p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">📊 Indikator Keberhasilan</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Seluruh siswa SDN 04 dapat memperagakan <strong>6 langkah cuci tangan yang benar</strong> serta memahami konsep gizi <strong>Isi Piringku</strong>.
                                </p>
                            </div>
                        </div>

                        <!-- Materi Sosialisasi Utama -->
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-navy-900 mb-4">Fokus Materi Sosialisasi</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="p-4 bg-white border border-gray-200 rounded-xl">
                                    <h3 class="text-base font-bold text-navy-900 mb-2">🧼 Praktik Cuci Tangan Pakai Sabun (CTPS)</h3>
                                    <ul class="text-sm text-gray-700 space-y-1.5 list-disc pl-5">
                                        <li>Pengenalan pentingnya menjaga kebersihan tangan sebelum makan dan setelah beraktivitas.</li>
                                        <li>Peragaan dan simulasi bersama 6 langkah mencuci tangan menggunakan sabun dan air mengalir.</li>
                                    </ul>
                                </div>

                                <div class="p-4 bg-white border border-gray-200 rounded-xl">
                                    <h3 class="text-base font-bold text-navy-900 mb-2">🍱 Edukasi Gizi "Isi Piringku"</h3>
                                    <ul class="text-sm text-gray-700 space-y-1.5 list-disc pl-5">
                                        <li>Pengenalan komposisi makanan sehat: makanan pokok, lauk pauk, buah-buahan, dan sayuran.</li>
                                        <li>Edukasi pentingnya membatasi jajanan tidak sehat serta minum air putih secukupnya setiap hari.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Dampak Program -->
                        <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl text-navy-900">
                            <h3 class="text-base font-bold text-navy-900 mb-2">Dampak & Manfaat Program</h3>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                Meningkatnya kesadaran, pengetahuan, serta kebiasaan penerapan pola hidup bersih dan sehat pada anak usia sekolah di Desa Pebadaran, yang berkontribusi pada penurunan risiko penularan penyakit serta peningkatan kebugaran fisik anak.
                            </p>
                        </div>
                    </div>
                '
            ],

            [
                'judul' => 'Pembuatan Papan Skor Bola Voli Lapangan Desa Pebadaran',
                'slug' => 'pembuatan-papan-skor-bola-voli-lapangan-desa-pebadaran',
                'kategori' => 'Pengembangan SDA dan Lingkungan',
                'thumbnail' => 'kukerta/papanskor/thumbnail.jpeg',
                'foto_dokumentasi' => [
                    'kukerta/papanskor/WhatsApp Image 2026-07-28 at 22.37.5412.jpeg',
                    'kukerta/papanskor/WhatsApp Image 2026-07-28 at 22.39.09.jpeg',
                    'kukerta/papanskor/WhatsApp Image 2026-07-28 at 22.39.091.jpeg',
                    'kukerta/papanskor/WhatsApp Image 2026-07-28 at 22.39.093.jpeg'
                ],
                'status' => 'Selesai',
                'tanggal_mulai' => '2026-07-11',
                'tanggal_selesai' => '2026-07-11',
                'is_published' => true,
                'published_at' => now(),
                'pelaksana' => [
                    ['nama' => 'TENGKU RISYA DWI JULIETHA', 'nim' => '2302113997', 'universitas' => 'Akuntansi - FEB'],
                    ['nama' => 'DIVA TRI RAMADANI', 'nim' => '2302112815', 'universitas' => 'Ekonomi Pembangunan - FEB'],
                    ['nama' => 'YURI MARISA', 'nim' => '2302111059', 'universitas' => 'Ekonomi Pembangunan - FEB'],
                    ['nama' => 'MUHAMMAD ABIDILLAH', 'nim' => '2307112117', 'universitas' => 'Teknik Informatika - FT'],
                    ['nama' => 'PUTRI AMALIA', 'nim' => '2304135528', 'universitas' => 'Teknologi Hasil Perikanan - FAPERIKA'],
                    ['nama' => 'SOFIA ARIFAH', 'nim' => '2305126938', 'universitas' => 'Pendidikan Bahasa Inggris - FKIP'],
                    ['nama' => 'DAFFA SHOHIBUL IKHSAN', 'nim' => '2306113726', 'universitas' => 'Agroteknologi - FP'],
                    ['nama' => 'M. SOHIBBAL', 'nim' => '2307135312', 'universitas' => 'Teknik Informatika - FT'],
                    ['nama' => 'HILMI AMINUDDIEN', 'nim' => '2307112162', 'universitas' => 'Teknik Informatika - FT'],
                    ['nama' => 'BEBY OKTAVIA', 'nim' => '2305111184', 'universitas' => 'Pendidikan Guru Sekolah Dasar - FKIP'],
                ],
                'konten' => '
                    <div class="space-y-6 text-navy-900">
                        <!-- Card Banner Ringkasan Program -->
                        <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-5 sm:p-6 text-navy-900">
                            <div class="flex items-center gap-2 text-royal font-bold text-xs sm:text-sm uppercase tracking-wider mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Program Kerja KUKERTA — Sarana Olahraga & Fasilitas Desa
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-navy-900 mb-2">Pembuatan Papan Skor Bola Voli Lapangan Desa Pebadaran</h3>
                            <p class="text-navy-800 text-sm sm:text-base leading-relaxed mb-4">
                                Pengadaan fasilitas papan skor fisik interaktif untuk menunjang kegiatan olahraga rutin masyarakat dan turnamen bola voli lokal di lapangan voli Kampung Pebadaran.
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3 border-t border-blue-200/70">
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Bidang</span>
                                    <span class="text-sm font-bold text-navy-900">SDA & Lingkungan</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Pelaksanaan</span>
                                    <span class="text-sm font-bold text-navy-900">11 Juli 2026</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Lokasi</span>
                                    <span class="text-sm font-bold text-navy-900">PEBADARAN</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Target</span>
                                    <span class="text-sm font-bold text-navy-900">Pemain Voli Desa</span>
                                </div>
                            </div>
                        </div>

                        <!-- Latar Belakang & Tujuan -->
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-navy-900 mb-3">Latar Belakang & Tujuan Program</h2>
                            <p class="text-gray-700 text-base leading-relaxed mb-3">
                                Olahraga bola voli merupakan salah satu kegiatan kemasyarakatan yang sangat diminati oleh pemuda dan warga Kampung Pebadaran. Namun, keterbatasan fasilitas seperti belum tersedianya papan pencatat skor resmi sering kali menyulitkan penghitungan poin saat pertandingan atau latihan rutin berlangsung.
                            </p>
                            <p class="text-gray-700 text-base leading-relaxed">
                                Melihat hal tersebut, Tim Mahasiswa KUKERTA berinisiatif merancang dan membuat <strong>Papan Skor Bola Voli</strong> yang tahan cuaca dan mudah digunakan oleh pemuda maupun warga sekitar di lapangan voli desa.
                            </p>
                        </div>

                        <!-- Target & Indikator Keberhasilan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">🎯 Target Sasaran</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Pemain bola voli, pemuda karang taruna, dan seluruh masyarakat Kampung Pebadaran.
                                </p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">📊 Indikator Keberhasilan</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Papan skor bola voli terpasang dan dapat digunakan secara optimal oleh warga untuk kegiatan main voli rutin maupun turnamen desa.
                                </p>
                            </div>
                        </div>

                        <!-- Dampak Program -->
                        <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl text-navy-900">
                            <h3 class="text-base font-bold text-navy-900 mb-2">Dampak & Manfaat Program</h3>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                Tersedianya papan skor bola voli yang meningkatkan kenyamanan dan kemudahan masyarakat Desa Pebadaran dalam menghitung poin pertandingan secara jelas, transparan, serta mendukung semangat berolahraga warga.
                            </p>
                        </div>
                    </div>
                '
            ],

            [
                'judul' => 'Mendekorasi Posyandu & Edukasi Visual Kesehatan Desa Pebadaran',
                'slug' => 'mendekorasi-posyandu-dan-edukasi-visual-kesehatan-desa-pebadaran',
                'kategori' => 'Kesehatan Masyarakat',
                'thumbnail' => 'kukerta/dekorasiPosyandu/thumbnail.jpeg',
                'foto_dokumentasi' => [
                    'kukerta/dekorasiPosyandu/WhatsApp Image 2026-07-28 at 22.46.58.jpeg',
                    'kukerta/dekorasiPosyandu/WhatsApp Image 2026-07-28 at 22.46.59.jpeg',
                    'kukerta/dekorasiPosyandu/WhatsApp Image 2026-07-28 at 22.47.39.jpeg'
                ],
                'status' => 'Selesai',
                'tanggal_mulai' => '2026-07-23',
                'tanggal_selesai' => '2026-07-23',
                'is_published' => true,
                'published_at' => now(),
                'pelaksana' => [
                    ['nama' => 'TENGKU RISYA DWI JULIETHA', 'nim' => '2302113997', 'universitas' => 'Akuntansi - FEB'],
                    ['nama' => 'DIVA TRI RAMADANI', 'nim' => '2302112815', 'universitas' => 'Ekonomi Pembangunan - FEB'],
                    ['nama' => 'YURI MARISA', 'nim' => '2302111059', 'universitas' => 'Ekonomi Pembangunan - FEB'],
                    ['nama' => 'PUTRI AMALIA', 'nim' => '2304135528', 'universitas' => 'Teknologi Hasil Perikanan - FAPERIKA'],
                    ['nama' => 'SOFIA ARIFAH', 'nim' => '2305126938', 'universitas' => 'Pendidikan Bahasa Inggris - FKIP'],
                    ['nama' => 'BEBY OKTAVIA', 'nim' => '2305111184', 'universitas' => 'Pendidikan Guru Sekolah Dasar - FKIP'],
                ],
                'konten' => '
                    <div class="space-y-6 text-navy-900">
                        <!-- Card Banner Ringkasan Program -->
                        <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-5 sm:p-6 text-navy-900">
                            <div class="flex items-center gap-2 text-royal font-bold text-xs sm:text-sm uppercase tracking-wider mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Program Kerja KUKERTA — Kesehatan Masyarakat & Gizi Seimbang
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-navy-900 mb-2">Program Mendekorasi Posyandu & Pemasangan Poster Edukasi Kesehatan</h3>
                            <p class="text-navy-800 text-sm sm:text-base leading-relaxed mb-4">
                                Kegiatan penataan dan pendekorasian ruang pelayanan Posyandu serta pemasangan media edukasi kesehatan visual guna menciptakan lingkungan pelayanan kesehatan yang nyaman, ramah anak, dan informatif.
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3 border-t border-blue-200/70">
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Bidang</span>
                                    <span class="text-sm font-bold text-navy-900">Kesehatan Masyarakat</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Pelaksanaan</span>
                                    <span class="text-sm font-bold text-navy-900">23 Juli 2026</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Lokasi</span>
                                    <span class="text-sm font-bold text-navy-900">Posyandu Pebadaran</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Target</span>
                                    <span class="text-sm font-bold text-navy-900">Pengurus & Ibu Hamil/Balita</span>
                                </div>
                            </div>
                        </div>

                        <!-- Latar Belakang & Tujuan -->
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-navy-900 mb-3">Latar Belakang & Tujuan Program</h2>
                            <p class="text-gray-700 text-base leading-relaxed mb-3">
                                Posyandu merupakan pusat pelayanan kesehatan masyarakat terdepan bagi ibu hamil, bayi, dan balita di Desa Pebadaran. Suasana ruangan yang bersih, indah, serta dilengkapi dengan infografis kesehatan yang menarik akan meningkatkan kenyamanan para pengunjung serta memudahkan penyampaian pesan-pesan kesehatan.
                            </p>
                            <p class="text-gray-700 text-base leading-relaxed">
                                Tim Mahasiswa KUKERTA melaksanakan kegiatan <strong>Mendekorasi Posyandu</strong> dengan merapikan area pelayanan, mempercantik ruangan, dan memasang poster edukasi kesehatan di titik-titik strategis yang mudah dibaca oleh pengunjung.
                            </p>
                        </div>

                        <!-- Target & Indikator Keberhasilan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">🎯 Target Sasaran</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Pengurus Posyandu, ibu hamil, ibu balita, serta seluruh pengunjung Posyandu Desa Pebadaran.
                                </p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">📊 Indikator Keberhasilan</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Poster kesehatan berhasil dipasang di Posyandu pada lokasi yang strategis, mudah dibaca oleh pengunjung, serta memuat informasi kesehatan yang jelas, menarik, dan sesuai dengan kebutuhan sasaran.
                                </p>
                            </div>
                        </div>

                        <!-- Dampak Program -->
                        <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl text-navy-900">
                            <h3 class="text-base font-bold text-navy-900 mb-2">Dampak & Manfaat Program</h3>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                Meningkatnya pengetahuan dan kesadaran masyarakat, khususnya ibu hamil, ibu balita, dan pengunjung Posyandu, mengenai pentingnya menjaga kesehatan sehingga mendorong penerapan perilaku hidup sehat dalam kehidupan sehari-hari.
                            </p>
                        </div>
                    </div>
                '
            ],

            [
                'judul' => 'Pembuatan & Digitalisasi Titik Lokasi UMKM Desa di Google Maps',
                'slug' => 'pembuatan-dan-digitalisasi-titik-lokasi-umkm-desa-di-google-maps',
                'kategori' => 'Digitalisasi Desa dan Layanan Publik',
                'thumbnail' => 'kukerta/googlemaps/thumbnail.jpeg',
                'foto_dokumentasi' => [
                    'kukerta/googlemaps/IMG-20260702-WA0032(1).jpg.jpeg',
                ],
                'status' => 'Selesai',
                'tanggal_mulai' => '2026-07-03',
                'tanggal_selesai' => '2026-07-03',
                'is_published' => true,
                'published_at' => now(),
                'pelaksana' => [
                    ['nama' => 'DIVA TRI RAMADANI', 'nim' => '2302112815', 'universitas' => 'Ekonomi Pembangunan - FEB'],
                    ['nama' => 'DAFFA SHOHIBUL IKHSAN', 'nim' => '2306113726', 'universitas' => 'Agroteknologi - FP'],
                    ['nama' => 'HILMI AMINUDDIEN', 'nim' => '2307112162', 'universitas' => 'Teknik Informatika - FT'],
                ],
                'konten' => '
                    <div class="space-y-6 text-navy-900">
                        <!-- Card Banner Ringkasan Program -->
                        <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-5 sm:p-6 text-navy-900">
                            <div class="flex items-center gap-2 text-royal font-bold text-xs sm:text-sm uppercase tracking-wider mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Program Kerja KUKERTA — Digitalisasi Desa & Layanan Publik
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-navy-900 mb-2">Pembuatan & Digitalisasi Titik Lokasi UMKM Desa di Google Maps</h3>
                            <p class="text-navy-800 text-sm sm:text-base leading-relaxed mb-4">
                                Pendataan, pendaftaran, dan pemetaan koordinat lokasi unit usaha UMKM lokal Desa Pebadaran ke platform Google Maps untuk mempermudah pencarian lokasi oleh wisatawan dan pelanggan secara digital.
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3 border-t border-blue-200/70">
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Bidang</span>
                                    <span class="text-sm font-bold text-navy-900">Digitalisasi Desa</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Pelaksanaan</span>
                                    <span class="text-sm font-bold text-navy-900">3 Juli 2026</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Lokasi</span>
                                    <span class="text-sm font-bold text-navy-900">PEBADARAN</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Target</span>
                                    <span class="text-sm font-bold text-navy-900">Pelaku UMKM Desa</span>
                                </div>
                            </div>
                        </div>

                        <!-- Latar Belakang & Tujuan -->
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-navy-900 mb-3">Latar Belakang & Tujuan Program</h2>
                            <p class="text-gray-700 text-base leading-relaxed mb-3">
                                Di era digital saat ini, keberadaan titik lokasi usaha pada peta digital (Google Maps) merupakan faktor vital dalam memperluas keterjangkauan usaha masyarakat. Banyak produk dan unit usaha UMKM potensial di Desa Pebadaran yang belum terdaftar di Google Maps sehingga sulit ditemukan oleh masyarakat luar desa.
                            </p>
                            <p class="text-gray-700 text-base leading-relaxed">
                                Tim Mahasiswa KUKERTA melaksanakan program <strong>Pembuatan & Digitalisasi Titik Lokasi UMKM Desa di Google Maps</strong> untuk membantu para pelaku UMKM lokal mendaftarkan tempat usaha mereka, menyematkan koordinat presisi, serta melengkapi informasi kontak dan foto usaha di layanan peta digital terpopuler tersebut.
                            </p>
                        </div>

                        <!-- Target & Indikator Keberhasilan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">🎯 Target Sasaran</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Seluruh pelaku usaha mikro, kecil, dan menengah (UMKM) serta unit usaha warga di Desa Pebadaran.
                                </p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">📊 Indikator Keberhasilan</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Seluruh UMKM sasaran berhasil terdaftar dan terverifikasi di platform Google Maps dengan koordinat lokasi yang akurat.
                                </p>
                            </div>
                        </div>

                        <!-- Dampak Program -->
                        <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl text-navy-900">
                            <h3 class="text-base font-bold text-navy-900 mb-2">Dampak & Manfaat Program</h3>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                Meningkatnya visibilitas, keterlihatan, serta jangkauan pasar UMKM Desa Pebadaran secara digital, memudahkan konsumen luar mendatangi lokasi usaha, dan mendukung pertumbuhan ekonomi lokal berbasis teknologi.
                            </p>
                        </div>
                    </div>
                '
            ],

            [
                'judul' => 'Pembuatan & Pengadaan VR (Virtual Reality) Jelajah Desa Pebadaran 360°',
                'slug' => 'pembuatan-dan-pengadaan-vr-virtual-reality-jelajah-desa-pebadaran-360',
                'kategori' => 'Teknologi Informasi',
                'thumbnail' => 'kukerta/vrdesa/thumbnail.png',
                'foto_dokumentasi' => [
                    'kukerta/vrdesa/Screenshot 2026-07-28 231033.png',
                    'kukerta/vrdesa/WhatsApp Image 2026-07-28 at 23.06.38.jpeg'
                ],
                'status' => 'Selesai',
                'tanggal_mulai' => '2026-07-03',
                'tanggal_selesai' => '2026-07-03',
                'is_published' => true,
                'published_at' => now(),
                'pelaksana' => [
                    ['nama' => 'MUHAMMAD ABIDILLAH', 'nim' => '2307112117', 'universitas' => 'Teknik Informatika - FT'],
                    ['nama' => 'M. SOHIBBAL', 'nim' => '2307135312', 'universitas' => 'Teknik Informatika - FT'],
                ],
                'konten' => '
                    <div class="space-y-6 text-navy-900">
                        <!-- Card Banner Ringkasan Program -->
                        <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-5 sm:p-6 text-navy-900">
                            <div class="flex items-center gap-2 text-royal font-bold text-xs sm:text-sm uppercase tracking-wider mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Program Kerja KUKERTA — Pengembangan TI & Komputer Desa
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-navy-900 mb-2">Pembuatan Virtual Reality (VR) 360° Jelajah Desa Pebadaran</h3>
                            <p class="text-navy-800 text-sm sm:text-base leading-relaxed mb-4">
                                Inovasi teknologi tur virtual 360 derajat yang memungkinkan masyarakat dan calon wisatawan menjelajahi keindahan, batas wilayah, serta fasilitas Desa Pebadaran secara interaktif melalui website resmi desa.
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3 border-t border-blue-200/70">
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Bidang</span>
                                    <span class="text-sm font-bold text-navy-900">Teknologi Informasi</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Pelaksanaan</span>
                                    <span class="text-sm font-bold text-navy-900">3 Juli 2026</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Lokasi</span>
                                    <span class="text-sm font-bold text-navy-900">PEBADARAN</span>
                                </div>
                                <div>
                                    <span class="text-xs text-navy-600 font-medium block">Target</span>
                                    <span class="text-sm font-bold text-navy-900">Publik & Pengunjung Web</span>
                                </div>
                            </div>
                        </div>

                        <!-- Latar Belakang & Tujuan -->
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-navy-900 mb-3">Latar Belakang & Tujuan Program</h2>
                            <p class="text-gray-700 text-base leading-relaxed mb-3">
                                Pemanfaatan teknologi digital mutakhir seperti <em>Virtual Reality</em> (VR) menjadi terobosan baru dalam mempromosikan potensi wilayah desa. Desa Pebadaran memiliki keindahan alam dan infrastruktur yang dapat disajikan secara impresif kepada khalayak umum tanpa batas wilayah.
                            </p>
                            <p class="text-gray-700 text-base leading-relaxed">
                                Tim Mahasiswa KUKERTA Fakultas Teknik Informatika menginisiasi program <strong>Pembuatan VR Desa Pebadaran 360°</strong> yang diintegrasikan secara langsung ke dalam portal web resmi desa, sehingga siapapun dapat melakukan eksplorasi virtual secara mulus dan responsif.
                            </p>
                        </div>

                        <!-- Target & Indikator Keberhasilan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">🎯 Target Sasaran</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Seluruh masyarakat Desa Pebadaran, pengunjung portal website desa, calon investor, dan wisatawan.
                                </p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                                <h3 class="text-base font-bold text-navy-900 mb-2">📊 Indikator Keberhasilan</h3>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Platform VR Desa Pebadaran berhasil dibuat, terintegrasi di website desa, dan dapat diakses publik dengan lancar serta responsif.
                                </p>
                            </div>
                        </div>

                        <!-- Dampak Program -->
                        <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl text-navy-900">
                            <h3 class="text-base font-bold text-navy-900 mb-2">Dampak & Manfaat Program</h3>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                Meningkatnya efektivitas promosi Desa Pebadaran secara digital, menghadirkan nilai tambah berupa daya tarik wisata visual mutakhir, serta memperkuat citra Desa Pebadaran sebagai desa cerdas (Smart Village) berbasis teknologi modern.
                            </p>
                        </div>
                    </div>
                '
            ],

        foreach ($kukertaList as $data) {
            Kukerta::create($data);
        }
    }
}
