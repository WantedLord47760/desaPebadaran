<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilDesa;

class ProfilDesaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'nama_desa' => 'Kampung Pebadaran',
            'kecamatan' => 'Pusako',
            'kabupaten' => 'Siak',
            'provinsi' => 'Riau',
            'luas_wilayah' => '16,22 km²',
            'koordinat' => '0°59\'43.6"LU dan 102°06\'43.1" BT',
            'total_penduduk' => '978',
            'total_kk' => '251',
            'alamat_kantor' => 'Kantor Kampung Pebadaran, Kecamatan Pusako, Kabupaten Siak, Riau',
            'sejarah' => '<div class="space-y-6 text-navy-800 leading-relaxed">
    <div class="bg-navy-900/5 p-6 rounded-2xl border-l-4 border-gold mb-6">
        <p class="text-lg font-medium italic text-navy-900">
            "Kampung Pebadaran adalah cerminan peradaban Melayu pesisir Sungai Siak yang sarat akan nilai sejarah, kebudayaan, dan semangat kegotongroyongan masyarakat dalam membangun benteng ekonomi dan tradisi lokal."
        </p>
    </div>

    <h3 class="text-2xl font-heading font-bold text-navy-900 border-b pb-2">1. Asal Usul Nama & Pemukiman Awal</h3>
    <p>
        Kampung Pebadaran merupakan salah satu wilayah pemukiman bersejarah yang berada di wilayah Kecamatan Pusako, Kabupaten Siak, Provinsi Riau. Secara geografis, lokasi kampung ini membentang di pesisir perairan Sungai Siak—salah satu sungai terpenting dalam sejarah peradaban dan jalur perdagangan utama di Semenanjung Melayu serta Kesultanan Siak Sri Indrapura.
    </p>
    <p>
        Nama <strong>"Pebadaran"</strong> menurut tuturan lisan tetua adat dan tokoh masyarakat setempat dipercayai berasal dari istilah lokal yang merujuk pada kawasan persinggahan (<em>pembadaran</em> atau tempat berhimpunnya para nelayan dan pedagang tradisional Melayu). Pada masa lampau, tepian sungai di wilayah ini menjadi titik strategis tempat bertambatnya perahu-perahu nelayan yang memanfaatkan kekayaan hayati Sungai Siak serta lahan pesisir yang subur untuk bercocok tanam.
    </p>

    <h3 class="text-2xl font-heading font-bold text-navy-900 border-b pb-2 mt-8">2. Keterikatan Historis dengan Kesultanan Siak</h3>
    <p>
        Keberadaan Kampung Pebadaran tidak lepas dari dinamika sejarah Kerajaan Siak Sri Indrapura. Jalur transportasi utama masyarakat pada masa lalu sepenuhnya mengandalkan lalu lintas perairan Sungai Siak. Warga awal Pebadaran dikenal memiliki keahlian tinggi dalam navigasi perairan, pembuatan perahu tradisional, serta pengelolaan hasil hutan dan pertanian pesisir.
    </p>
    <p>
        Kehidupan masyarakat sejak era dahulu telah dipengaruhi secara kuat oleh adat istiadat Melayu yang bersendikan syariat Islam. Keharmonisan hidup bermasyarakat dijaga melalui tatanan adat yang dipimpin oleh tetua kampung dan pimpinan keagamaan, di mana nilai-nilai musyawarah dan gotong royong senantiasa dijunjung tinggi.
    </p>

    <h3 class="text-2xl font-heading font-bold text-navy-900 border-b pb-2 mt-8">3. Perkembangan Era Modern & Pemekaran Wilayah</h3>
    <p>
        Seiring dengan perkembangan zaman dan ditetapkannya Undang-Undang Otonomi Daerah serta pembentukan Kabupaten Siak, Kampung Pebadaran mengalami proses penataan administratif secara bertahap. Dari pemukiman tradisional, wilayah ini berkembang menjadi kampung definitif yang terus membenahi tatanan organisasinya di bawah Kecamatan Pusako.
    </p>
    <p>
        Transformasi signifikan terjadi pada alih fungsi dan modernisasi mata pencaharian warga. Jika dahulu mayoritas penduduk bergantung pada hasil tangkapan sungai dan pertanian subsisten, kini sektor perkebunan kelapa sawit, komoditas holtikultura, dan usaha mikro BUMKam (Badan Usaha Milik Kampung) menjadi tulang punggung utama perekonomian masyarakat. Pembukaan jalan-jalan darat juga semakin membuka aksesibilitas Kampung Pebadaran ke pusat pemerintahan kabupaten dan daerah tetangga.
    </p>

    <h3 class="text-2xl font-heading font-bold text-navy-900 border-b pb-2 mt-8">4. Kampung Pebadaran Masa Kini</h3>
    <p>
        Saat ini, Kampung Pebadaran terus bersolek menjadi kampung yang mandiri, sejahtera, dan berdaya saing dengan tetap memelihara nilai-nilai kearifan lokal Melayu. Berbagai program pembangunan infrastruktur publik, sarana pendidikan (PAUD, TK, SD), pusat pelayanan kesehatan (Puskesmas/Posyandu), hingga pengembangan tempat ibadah terus ditingkatkan.
    </p>
    <p>
        Sinergi antara Pemerintah Kampung, BAPEKAM, tokoh masyarakat, Karang Taruna, serta kolaborasi bersama perguruan tinggi melalui kegiatan Kuliah Kerja Nyata (KuKerTa) senantiasa menjadi pendorong inovasi demi mewujudkan kemajuan Kampung Pebadaran di masa depan.
    </p>
</div>',
            'batas_utara' => 'Dusun Pusaka',
            'batas_timur' => 'Mengkapan',
            'batas_barat' => 'Sungai Siak',
            'batas_selatan' => 'Kampung Benayah',
            'fasilitas' => json_encode(['Kantor Kampung', 'KUA', 'BUMKam', 'PAUD Permata Bunda', 'TK Buah Hati Bunda', 'SD Negeri 04', 'Posyandu', 'Puskesmas & UGD', 'Masjid At-Taqwa', 'Mushalla Nurul-Hasanah', 'Lapangan Bola Voli', 'Lapangan Bulu Tangkis']),
            'lembaga' => json_encode(['Pemerintah Kampung', 'BAPEKAM', 'Kepala Dusun RT/RW', 'BUMKAM', 'PKK', 'Karang Taruna']),
        ];

        foreach ($data as $key => $value) {
            ProfilDesa::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
