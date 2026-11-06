<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use Illuminate\Database\Seeder;

class KurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. PENGANTAR / HERO
        Kurikulum::updateOrCreate(
            ['tipe' => 'pengantar', 'kategori' => 'hero'],
            [
                'judul'     => 'Kurikulum & Pembelajaran',
                'deskripsi' => "SMP Sains Al-Qur'an Klakah menerapkan kurikulum terintegrasi yang mengharmoniskan standar Kurikulum Merdeka dengan pendalaman Sains Modern Berbasis Riset serta keagungan Tahfidz Al-Qur'an.",
                'ikon'      => 'bi-book-half',
                'poin_poin' => 'Sistem Pendidikan Terpadu',
                'urutan'    => 1,
                'is_active' => true,
            ]
        );

        // 2. TIGA PILAR KURIKULUM
        $pilars = [
            [
                'judul'     => 'Kurikulum Merdeka',
                'deskripsi' => 'Menerapkan standar nasional Kemendikbudristek dengan pendekatan pembelajaran berdiferensiasi, berbasis proyek (P5), serta berfokus pada penguatan nalar kritis, literasi, dan numerasi.',
                'ikon'      => 'bi-mortarboard-fill',
                'kategori'  => 'merdeka',
                'poin_poin' => "Pembelajaran Berbasis Proyek (P5)\nAsesmen Kompetensi & Bakat Siswa\nFleksibilitas Eksplorasi Minat Belajar",
                'urutan'    => 1,
            ],
            [
                'judul'     => 'Sains & Riset Terapan',
                'deskripsi' => 'Mengasah cara berpikir ilmiah santri melalui pembelajaran kontekstual, praktikum sains di laboratorium, pemanfaatan teknologi informatika, dan pembinaan olimpiade sains (OSN).',
                'ikon'      => 'bi-cpu',
                'kategori'  => 'sains',
                'poin_poin' => "Praktikum Laboratorium Sains Rutin\nBimbingan Riset & Karya Ilmiah Santri\nPembinaan Olimpiade Sains & Matematika",
                'urutan'    => 2,
            ],
            [
                'judul'     => 'Tahfidz & Diniyah',
                'deskripsi' => "Program intensif hafalan Al-Qur'an dengan bimbingan ustadz berpengalaman, metode talaqqi & muroja'ah bersanad, serta penanaman adab islami dan pemahaman fiqih ibadah sehari-hari.",
                'ikon'      => 'bi-book-half',
                'kategori'  => 'tahfidz',
                'poin_poin' => "Target Hafalan Terukur & Berkala\nTahsin Makharijul Huruf & Tajwid\nPembiasaan Ibadah & Karakter Qur'ani",
                'urutan'    => 3,
            ],
        ];

        foreach ($pilars as $p) {
            Kurikulum::updateOrCreate(
                ['tipe' => 'pilar', 'judul' => $p['judul']],
                array_merge($p, ['is_active' => true])
            );
        }

        // 3. MATA PELAJARAN - UMUM
        $mapelUmum = [
            ['judul' => 'Matematika', 'deskripsi' => 'Penalaran logis & numerasi terapan', 'ikon' => 'bi-calculator', 'urutan' => 1],
            ['judul' => 'Ilmu Pengetahuan Alam (IPA)', 'deskripsi' => 'Fisika, Biologi, Kimia Dasar terintegrasi', 'ikon' => 'bi-flower1', 'urutan' => 2],
            ['judul' => 'Bahasa Indonesia', 'deskripsi' => 'Kemampuan literasi, retorika, & penulisan', 'ikon' => 'bi-chat-left-text', 'urutan' => 3],
            ['judul' => 'Bahasa Inggris', 'deskripsi' => 'Komunikasi global & tata bahasa aktif', 'ikon' => 'bi-translate', 'urutan' => 4],
            ['judul' => 'Ilmu Pengetahuan Sosial (IPS)', 'deskripsi' => 'Geografi, sejarah, sosiologi, & ekonomi', 'ikon' => 'bi-globe', 'urutan' => 5],
            ['judul' => 'Pendidikan Pancasila (PPKn)', 'deskripsi' => 'Kewarganegaraan, hukum, & kebangsaan', 'ikon' => 'bi-shield-check', 'urutan' => 6],
        ];

        foreach ($mapelUmum as $m) {
            Kurikulum::updateOrCreate(
                ['tipe' => 'mapel', 'kategori' => 'umum', 'judul' => $m['judul']],
                array_merge($m, ['is_active' => true])
            );
        }

        // 4. MATA PELAJARAN - KEISLAMAN
        $mapelIslam = [
            ['judul' => "Tahfidzul Qur'an", 'deskripsi' => "Halaqah setoran ziyadah & muroja'ah harian", 'ikon' => 'bi-book', 'urutan' => 1],
            ['judul' => 'Tahsin & Ilmu Tajwid', 'deskripsi' => 'Standarisasi makharijul huruf & hukum bacaan', 'ikon' => 'bi-mic', 'urutan' => 2],
            ['judul' => 'Bahasa Arab', 'deskripsi' => "Kosakata, percakapan, & kaidah dasar bahasa Qur'an", 'ikon' => 'bi-fonts', 'urutan' => 3],
            ['judul' => 'Aqidah & Akhlak', 'deskripsi' => 'Penguatan tauhid & pembinaan budi pekerti luhur', 'ikon' => 'bi-heart-pulse', 'urutan' => 4],
            ['judul' => 'Fiqih Ibadah', 'deskripsi' => 'Tata cara bersuci, sholat, puasa, & adab islami', 'ikon' => 'bi-water', 'urutan' => 5],
            ['judul' => 'Sejarah Kebudayaan Islam (SKI)', 'deskripsi' => 'Teladan Rasulullah SAW, sahabat, & peradaban Islam', 'ikon' => 'bi-hourglass-split', 'urutan' => 6],
        ];

        foreach ($mapelIslam as $m) {
            Kurikulum::updateOrCreate(
                ['tipe' => 'mapel', 'kategori' => 'islam', 'judul' => $m['judul']],
                array_merge($m, ['is_active' => true])
            );
        }

        // 5. MATA PELAJARAN - SAINS & PENGEMBANGAN DIRI
        $mapelSains = [
            ['judul' => 'Informatika & Komputer', 'deskripsi' => 'Literasi digital, komputasi nalar, & aplikasi dasar', 'ikon' => 'bi-laptop', 'urutan' => 1],
            ['judul' => 'Karya Ilmiah Remaja (KIR)', 'deskripsi' => 'Metodologi riset sederhana & eksperimen sains', 'ikon' => 'bi-eyedropper', 'urutan' => 2],
            ['judul' => 'Klub Olimpiade Sains (OSN)', 'deskripsi' => 'Intensif pemantapan IPA & Matematika kompetisi', 'ikon' => 'bi-trophy', 'urutan' => 3],
            ['judul' => 'Seni & Ragam Ekstrakurikuler', 'deskripsi' => 'Pramuka, kaligrafi, bela diri, olahraga, & bahasa', 'ikon' => 'bi-palette', 'urutan' => 4],
        ];

        foreach ($mapelSains as $m) {
            Kurikulum::updateOrCreate(
                ['tipe' => 'mapel', 'kategori' => 'sains', 'judul' => $m['judul']],
                array_merge($m, ['is_active' => true])
            );
        }

        // 6. TARGET CAPAIAN LULUSAN
        $capaians = [
            ['judul' => "Hafal Al-Qur'an", 'deskripsi' => "Memiliki hafalan Al-Qur'an mutqin dengan bacaan tajwid yang tertib dan berstandar.", 'ikon' => 'bi-book-half', 'urutan' => 1],
            ['judul' => 'Unggul dalam Sains', 'deskripsi' => 'Mampu berpikir logis, analitis, dan memiliki keterampilan riset ilmiah dasar yang kuat.', 'ikon' => 'bi-lightbulb-fill', 'urutan' => 2],
            ['judul' => "Berakhlak Qur'ani", 'deskripsi' => 'Meneladani akhlak Rasulullah SAW, disiplin ibadah, santun, dan mandiri dalam keseharian.', 'ikon' => 'bi-shield-check', 'urutan' => 3],
            ['judul' => 'Siap Melanjutkan', 'deskripsi' => 'Memiliki bekal kompetensi akademik yang prima untuk bersaing di jenjang SLTA/MA unggulan.', 'ikon' => 'bi-compass-fill', 'urutan' => 4],
        ];

        foreach ($capaians as $c) {
            Kurikulum::updateOrCreate(
                ['tipe' => 'capaian', 'judul' => $c['judul']],
                array_merge($c, ['is_active' => true])
            );
        }
    }
}

