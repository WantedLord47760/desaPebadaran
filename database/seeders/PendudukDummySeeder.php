<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * PendudukDummySeeder
 * ─────────────────────────────────────────────────────────────────────────────
 * Mengisi data warga ke tabel `keluarga` dan `warga` berdasarkan
 * data riil demografi Kampung Pebadaran Mei 2026.
 *
 * Target : 978 jiwa  →  479 Laki-laki + 499 Perempuan
 *          250 KK    →  rata-rata 3,9 jiwa/KK
 */
class PendudukDummySeeder extends Seeder
{
    // ─── Kolam Nama Indonesia ────────────────────────────────────────────────

    private array $namaDepanL = [
        'Ahmad', 'Muhammad', 'Abdullah', 'Rizky', 'Andi', 'Budi', 'Dedi',
        'Eko', 'Fajar', 'Gunawan', 'Hendra', 'Irwan', 'Joko', 'Kurniawan',
        'Lukman', 'Maman', 'Nanang', 'Ony', 'Prayoga', 'Rachmat',
        'Suharto', 'Teguh', 'Udin', 'Wahyu', 'Yanto', 'Zaenal',
        'Agus', 'Arif', 'Bagas', 'Candra', 'Danu', 'Eddy', 'Feri',
        'Gilang', 'Hadi', 'Ivan', 'Jony', 'Krisna', 'Leo', 'Miko',
        'Nanda', 'Oscar', 'Panji', 'Rafi', 'Salim', 'Taufik', 'Ucup',
        'Vino', 'Wawan', 'Yoga', 'Zaki', 'Alif', 'Bima', 'Cahyo',
        'Dimas', 'Farid', 'Galih', 'Habib', 'Ilham', 'Jamal', 'Kamal',
        'Latif', 'Marwan', 'Nasrul', 'Oky', 'Putra', 'Qodir', 'Rendra',
        'Saiful', 'Toni', 'Usman', 'Valdi', 'Wisnu', 'Yudha', 'Zulham',
    ];

    private array $namaDepanP = [
        'Siti', 'Nur', 'Dewi', 'Rina', 'Ani', 'Citra', 'Dina',
        'Erni', 'Fitri', 'Galuh', 'Heni', 'Indah', 'Juwita', 'Kartini',
        'Lestari', 'Mira', 'Nita', 'Oktavia', 'Putri', 'Rahma', 'Sri',
        'Tini', 'Utami', 'Vani', 'Wulandari', 'Yuni', 'Zahra',
        'Aini', 'Bella', 'Cantika', 'Diah', 'Elsa', 'Fauziah',
        'Gita', 'Hana', 'Ika', 'Jannah', 'Karina', 'Laila',
        'Maya', 'Nabila', 'Olivia', 'Puspita', 'Risa', 'Selvi',
        'Tari', 'Umi', 'Vera', 'Widya', 'Yola', 'Zulfa',
        'Amelia', 'Bunga', 'Cindy', 'Desi', 'Erika', 'Fanny',
        'Gracia', 'Hesty', 'Irma', 'Juliana', 'Kurnia', 'Linda',
        'Mela', 'Nadia', 'Okta', 'Prita', 'Rini', 'Susi',
        'Tika', 'Ulfa', 'Vina', 'Wati', 'Yanti', 'Zsa',
    ];

    private array $namaBelakang = [
        'Santoso', 'Wibowo', 'Susanto', 'Sari', 'Setiawan', 'Rahayu',
        'Permata', 'Kusuma', 'Handoko', 'Pratama', 'Nugroho', 'Saputra',
        'Ramadan', 'Hidayat', 'Hakim', 'Maulana', 'Firdaus', 'Anwar',
        'Wahyudi', 'Sulistyo', 'Utomo', 'Purnomo', 'Sugianto', 'Hartono',
        'Purwanto', 'Salim', 'Ibrahim', 'Hasan', 'Yusuf', 'Aziz',
        'Rasyid', 'Effendi', 'Gunawan', 'Wijaya', 'Budiman', 'Priyadi',
        'Irawan', 'Cahyono', 'Basuki', 'Mulyono', 'Kurniadi', 'Hermawan',
        'Sudirman', 'Prasetyo', 'Firmansyah', 'Rohman', 'Hamdani',
        'Iskandar', 'Mansur', 'Nasution',
    ];

    private array $kota = [
        'Pebadaran', 'Cirebon', 'Indramayu', 'Subang', 'Brebes',
        'Majalengka', 'Kuningan', 'Losari', 'Gebang', 'Ciledug',
        'Palimanan', 'Losarang', 'Kandanghaur', 'Karangampel', 'Arjawinangun',
        'Patrol', 'Anjatan', 'Sukra', 'Gantar', 'Widasari',
    ];

    private array $dusun = ['Dusun I', 'Dusun II', 'Dusun III'];

    private array $rtRw = [
        ['rt' => '001', 'rw' => '001'],
        ['rt' => '002', 'rw' => '001'],
        ['rt' => '003', 'rw' => '001'],
        ['rt' => '001', 'rw' => '002'],
        ['rt' => '002', 'rw' => '002'],
        ['rt' => '003', 'rw' => '002'],
        ['rt' => '001', 'rw' => '003'],
        ['rt' => '002', 'rw' => '003'],
        ['rt' => '003', 'rw' => '003'],
    ];

    // ─── Helper Probabilitas ─────────────────────────────────────────────────

    /** Pilih item dari array berbobot ['item' => berat] */
    private function weightedRandom(array $items): string
    {
        $totalWeight = array_sum($items);
        $rand        = mt_rand(1, (int)($totalWeight * 1000)) / 1000;
        $cumulative  = 0;

        foreach ($items as $item => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return (string)$item;
            }
        }

        return (string)array_key_last($items);
    }

    /** Mengembalikan [minUmur, maxUmur] berdasarkan distribusi demografis */
    private function getUmurRange(): array
    {
        $groups = [
            ['min' => 0,  'max' => 5,  'weight' => 16.8],
            ['min' => 6,  'max' => 12, 'weight' => 12.6],
            ['min' => 13, 'max' => 16, 'weight' => 11.2],
            ['min' => 17, 'max' => 19, 'weight' => 12.2],
            ['min' => 20, 'max' => 25, 'weight' =>  7.2],
            ['min' => 26, 'max' => 39, 'weight' => 15.8],
            ['min' => 40, 'max' => 55, 'weight' => 11.7],
            ['min' => 56, 'max' => 60, 'weight' =>  9.6],
            ['min' => 61, 'max' => 90, 'weight' =>  3.0],
        ];

        $totalWeight = array_sum(array_column($groups, 'weight'));
        $rand        = mt_rand(1, (int)($totalWeight * 1000)) / 1000;
        $cumulative  = 0;

        foreach ($groups as $group) {
            $cumulative += $group['weight'];
            if ($rand <= $cumulative) {
                return [$group['min'], $group['max']];
            }
        }

        return [26, 39];
    }

    private function getAgama(): string
    {
        return $this->weightedRandom([
            'Islam'   => 94.7,
            'Kristen' =>  4.5,
            'Katolik' =>  0.5,
            'Buddha'  =>  0.3,
        ]);
    }

    /** Pekerjaan disesuaikan usia: ≤16 th → wajib Belum/Tidak Bekerja */
    private function getPekerjaan(int $umur): string
    {
        if ($umur <= 16) return 'Belum/Tidak Bekerja';

        return $this->weightedRandom([
            'Belum/Tidak Bekerja' => 48.2,
            'Petani'              => 41.3,
            'Buruh'               =>  3.6,
            'Swasta'              =>  3.3,
            'PNS'                 =>  1.9,
            'Nelayan'             =>  1.7,
        ]);
    }

    /** Pendidikan disesuaikan usia: ≤5 th → wajib Tidak/Belum Sekolah */
    private function getPendidikan(int $umur): string
    {
        if ($umur <= 5) return 'Tidak/Belum Sekolah';

        return $this->weightedRandom([
            'SD'                  => 30.9,
            'SLTP'                => 21.6,
            'SLTA'                => 21.3,
            'Tidak/Belum Sekolah' => 20.1,
            'S1'                  =>  4.4,
            'Diploma'             =>  1.5,
            'S2'                  =>  0.2,
        ]);
    }

    private function getStatusPerkawinan(int $umur): string
    {
        if ($umur < 17) return 'Belum Kawin';
        if ($umur < 20) return mt_rand(0, 100) < 88 ? 'Belum Kawin' : 'Kawin';
        if ($umur < 25) return mt_rand(0, 100) < 55 ? 'Belum Kawin' : 'Kawin';

        $rand = mt_rand(0, 100);
        if ($rand < 75) return 'Kawin';
        if ($rand < 88) return 'Belum Kawin';
        if ($rand < 96) return 'Cerai Mati';
        return 'Cerai Hidup';
    }

    private function getStatusDalamKeluarga(int $posisi): string
    {
        return match (true) {
            $posisi === 0 => 'Kepala Keluarga',
            $posisi === 1 => mt_rand(0, 100) < 82 ? 'Istri' : 'Anak',
            default       => mt_rand(0, 100) < 85 ? 'Anak' : 'Famili Lain',
        };
    }

    private function generateNik(array &$used): string
    {
        do {
            $nik = '321301'
                . str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT)
                . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (isset($used[$nik]));

        $used[$nik] = true;
        return $nik;
    }

    private function generateNoKk(array &$used): string
    {
        do {
            $kk = '3213011'
                . str_pad(mt_rand(1000000, 9999999), 7, '0', STR_PAD_LEFT)
                . str_pad(mt_rand(10, 99), 2, '0', STR_PAD_LEFT);
        } while (isset($used[$kk]));

        $used[$kk] = true;
        return $kk;
    }

    private function randomNama(string $jk): string
    {
        $depan    = $jk === 'L'
            ? $this->namaDepanL[array_rand($this->namaDepanL)]
            : $this->namaDepanP[array_rand($this->namaDepanP)];
        $belakang = $this->namaBelakang[array_rand($this->namaBelakang)];

        return mt_rand(0, 100) < 30 ? $depan : "$depan $belakang";
    }

    // ─── Bangun daftar jenis kelamin secara deterministik ───────────────────

    /**
     * Kembalikan array 978 elemen string ('L'/'P') yang sudah diacak,
     * dengan komposisi persis 479 L dan 499 P.
     */
    private function buildGenderPool(): array
    {
        $pool = array_merge(array_fill(0, 479, 'L'), array_fill(0, 499, 'P'));
        shuffle($pool);
        return $pool;
    }

    // ─── Bangun distribusi anggota per KK ───────────────────────────────────

    /**
     * Distribusikan $totalWarga ke $totalKK kelompok sehingga
     * setiap KK punya minimal 2 anggota dan total tepat $totalWarga.
     *
     * @return int[]
     */
    private function buildDistribution(int $totalWarga, int $totalKK): array
    {
        // Mulai semua KK dengan 2 anggota (minimum)
        $dist = array_fill(0, $totalKK, 2);
        $sisa = $totalWarga - ($totalKK * 2); // sisa untuk dibagikan

        // Bagikan sisa secara acak ke KK yang belum penuh (maks 8 anggota)
        while ($sisa > 0) {
            $idx = mt_rand(0, $totalKK - 1);
            if ($dist[$idx] < 8) {
                $dist[$idx]++;
                $sisa--;
            }
        }

        return $dist;
    }

    // ─── Run ─────────────────────────────────────────────────────────────────

    public function run(): void
    {
        $TARGET_WARGA = 978;
        $TARGET_KK    = 250;
        $now          = now();

        // ── Bersihkan data lama ──────────────────────────────────────────────
        $this->command->info('🗑️  Membersihkan data keluarga & warga lama...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('warga')->truncate();
        DB::table('keluarga')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ── Siapkan pool & distribusi ────────────────────────────────────────
        $genderPool  = $this->buildGenderPool();      // 978 elemen, 479 L + 499 P
        $distribusi  = $this->buildDistribution($TARGET_WARGA, $TARGET_KK);
        $usedNiks    = [];
        $usedKks     = [];
        $genderIndex = 0;

        $this->command->info("🏘️  PendudukDummySeeder mulai...");
        $this->command->info("   Target Warga : {$TARGET_WARGA} jiwa (479 L + 499 P)");
        $this->command->info("   Target KK    : {$TARGET_KK} KK");
        $this->command->newLine();

        $totalInserted = 0;
        $countL        = 0;
        $countP        = 0;

        // ── Batch insert (lebih cepat) ───────────────────────────────────────
        $keluargaBatch = [];
        $wargaBatch    = [];

        foreach ($distribusi as $kkIndex => $jumlahAnggota) {
            $noKk     = $this->generateNoKk($usedKks);
            $rtRwPick = $this->rtRw[array_rand($this->rtRw)];
            $dusunPick = $this->dusun[array_rand($this->dusun)];
            $alamat   = 'Jl. Desa Pebadaran RT ' . $rtRwPick['rt'] . ' RW ' . $rtRwPick['rw'];

            // Nama kepala KK selalu L, diambil dari pool
            // (pastikan slot KK-head pakai gender L)
            $namaKepala = $this->randomNama('L');

            // Insert KK dan dapatkan ID
            $keluargaId = DB::table('keluarga')->insertGetId([
                'no_kk'           => $noKk,
                'kepala_keluarga' => $namaKepala,
                'alamat'          => $alamat,
                'rt'              => $rtRwPick['rt'],
                'rw'              => $rtRwPick['rw'],
                'dusun'           => $dusunPick,
                'created_at'      => $now,
                'updated_at'      => $now,
            ]);

            for ($i = 0; $i < $jumlahAnggota; $i++) {
                // Ambil jenis kelamin dari pool yang sudah deterministik
                // Kepala keluarga (posisi 0) selalu L; ambil dari sisa pool
                if ($i === 0) {
                    $jenisKelamin = 'L';
                    // Geser pointer pool melewati slot ini (L dari pool akan tetap terhitung)
                    // Cari index L berikutnya dan tukar ke posisi genderIndex
                    for ($j = $genderIndex; $j < count($genderPool); $j++) {
                        if ($genderPool[$j] === 'L') {
                            // Tukar supaya L ada di posisi genderIndex
                            [$genderPool[$genderIndex], $genderPool[$j]] = [$genderPool[$j], $genderPool[$genderIndex]];
                            break;
                        }
                    }
                } else {
                    $jenisKelamin = $genderPool[$genderIndex] ?? 'L';
                }

                $genderIndex++;

                // Umur
                [$minU, $maxU] = $this->getUmurRange();
                $umur = mt_rand($minU, $maxU);

                // Kepala KK minimal usia 25 tahun
                if ($i === 0 && $umur < 25) {
                    $umur = mt_rand(25, 55);
                }

                // Tanggal lahir acak dalam rentang tahun lahirnya
                $tahunLahir   = 2026 - $umur;
                $startTs      = Carbon::create($tahunLahir, 1, 1)->timestamp;
                $endTs        = Carbon::create($tahunLahir, 12, 31)->timestamp;
                $tanggalLahir = Carbon::createFromTimestamp(mt_rand($startTs, $endTs))->toDateString();

                $nama = $i === 0 ? $namaKepala : $this->randomNama($jenisKelamin);

                $wargaBatch[] = [
                    'keluarga_id'             => $keluargaId,
                    'nik'                     => $this->generateNik($usedNiks),
                    'nama'                    => $nama,
                    'tempat_lahir'            => $this->kota[array_rand($this->kota)],
                    'tanggal_lahir'           => $tanggalLahir,
                    'jenis_kelamin'           => $jenisKelamin,
                    'agama'                   => $this->getAgama(),
                    'status_perkawinan'       => $this->getStatusPerkawinan($umur),
                    'pekerjaan'               => $this->getPekerjaan($umur),
                    'pendidikan_terakhir'     => $this->getPendidikan($umur),
                    'status_dalam_keluarga'   => $this->getStatusDalamKeluarga($i),
                    'golongan_darah'          => $this->weightedRandom(['A' => 28, 'B' => 28, 'O' => 28, 'AB' => 16]),
                    'is_active'               => true,
                    'created_at'              => $now,
                    'updated_at'              => $now,
                ];

                if ($jenisKelamin === 'L') $countL++;
                else $countP++;
                $totalInserted++;

                // Flush batch warga setiap 100 record
                if (count($wargaBatch) >= 100) {
                    DB::table('warga')->insert($wargaBatch);
                    $wargaBatch = [];
                }
            }

            // Progress setiap 50 KK
            if (($kkIndex + 1) % 50 === 0 || ($kkIndex + 1) === $TARGET_KK) {
                $this->command->line(
                    "   → KK #{" . str_pad($kkIndex + 1, 3, ' ', STR_PAD_LEFT)
                    . "}/{$TARGET_KK}  |  Warga tercatat: {$totalInserted}"
                );
            }
        }

        // Flush sisa batch
        if (!empty($wargaBatch)) {
            DB::table('warga')->insert($wargaBatch);
        }

        // ── Ringkasan ────────────────────────────────────────────────────────
        $this->command->newLine();
        $this->command->info('✅ Seeding selesai!');
        $this->command->table(
            ['Metrik', 'Target', 'Aktual'],
            [
                ['Total Warga',       $TARGET_WARGA, $totalInserted],
                ['Laki-laki (L)',     '479',          $countL],
                ['Perempuan (P)',     '499',          $countP],
                ['Total KK',         $TARGET_KK,     $TARGET_KK],
                ['Rata-rata jiwa/KK', number_format($TARGET_WARGA / $TARGET_KK, 1), number_format($totalInserted / $TARGET_KK, 1)],
            ]
        );
    }
}
