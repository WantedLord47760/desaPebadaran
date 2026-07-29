<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisiMisi;

class VisiMisiSeeder extends Seeder
{
    public function run(): void
    {
        VisiMisi::updateOrCreate(
            ['tipe' => 'visi', 'urutan' => 1],
            ['konten' => 'Mewujudkan Desa / Kampung Pebadaran Yang "SANTRI" Sejahtera, Aman, Nyaman, Tertib, Religius, dan Inovatif']
        );

        $misi = [
            'Meningkatkan Keimanan dan Ketaqwaan Pada Allah SWT.',
            'Mewujudkan Profesionalisme dan Penataan Pemerintahan Desa Yang Efektif dan Efisien.',
            'Meningkatkan Sarana dan Prasarana Yang Mendukung Dalam Kehidupan Masyarakat.',
            'Meningkatkan Kwalitas Sumber Daya Masyarakat dibidang Kesehatan, Ekonomi, Pendidikan dan Olahraga.',
            'Mewujudkan Kebersihan, Keamanan dan Ketertiban Masyarakat.',
            'Meningkatkan Kesadaran Masyarakat Dalam Membangun Desa Melalui Seluruh Lembaga Masyarakat.',
            'Melestarikan Adat Istiadat dan Seni Budaya'
        ];

        foreach ($misi as $index => $item) {
            VisiMisi::updateOrCreate(
                ['tipe' => 'misi', 'urutan' => $index + 1],
                ['konten' => $item]
            );
        }
    }
}
