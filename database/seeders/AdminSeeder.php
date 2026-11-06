<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProfilSekolah;
use App\Models\HeroSlider;
use App\Models\ProgramUnggulan;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@smpsainsquran.sch.id'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // Create default profil sekolah
        ProfilSekolah::firstOrCreate(
            ['id' => 1],
            [
                'nama_sekolah'   => 'SMP Sains Al-Qur\'an Klakah',
                'tagline'        => 'Membentuk Generasi Qur\'ani yang Cerdas, Mandiri, dan Berakhlak Mulia',
                'deskripsi'      => 'SMP Sains Al-Qur\'an Klakah adalah lembaga pendidikan menengah pertama yang berada di bawah naungan Yahtadi Islamic Education Center, menggabungkan pendidikan sains modern dengan kedalaman nilai-nilai Al-Qur\'an.',
                'sejarah'        => 'SMP Sains Al-Qur\'an Klakah didirikan sebagai bagian dari Yahtadi Islamic Education Center dengan visi mencetak generasi muda yang memiliki keseimbangan antara ilmu pengetahuan dan nilai-nilai Islam. Sekolah ini berlokasi di Kecamatan Klakah, Kabupaten Lumajang, Jawa Timur.',
                'visi'           => 'Terwujudnya generasi Qur\'ani yang cerdas, mandiri, berkarakter, dan berprestasi dalam bidang sains dan keislaman.',
                'misi'           => "1. Menyelenggarakan pendidikan yang mengintegrasikan sains dan Al-Qur'an\n2. Membentuk peserta didik yang hafal Al-Qur'an dan memahami isinya\n3. Mengembangkan potensi akademik dan non-akademik peserta didik\n4. Membangun karakter islami yang berakhlak mulia\n5. Menyediakan lingkungan belajar yang kondusif dan islami",
                'nama_kepsek'    => 'Kepala Sekolah',
                'sambutan_kepsek'=> 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di website resmi SMP Sains Al-Qur\'an Klakah. Kami berkomitmen mencetak lulusan yang berakhlak mulia, cerdas, dan unggul dalam ilmu pengetahuan serta berjiwa Qur\'ani.',
                'alamat'         => 'Kecamatan Klakah, Kabupaten Lumajang, Jawa Timur',
                'telepon'        => '(0334) 881866',
                'email'          => 'info@smpsainsquran.sch.id',
                'whatsapp'       => '6287612346453',
                'instagram'      => 'https://www.instagram.com/smpsainsquranklakah/',
                'youtube'        => 'https://www.youtube.com/@smpsainsquranklakah',
                'maps_embed'     => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126425.49257840867!2d113.16242646611147!3d-8.019894112444272!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd65bfaa61c7e27%3A0xa113f43ba4a9a688!2sYAHTADI%20ISLAMIC%20EDUCATION%20CENTER!5e0!3m2!1sid!2sid!4v1764706817064!5m2!1sid!2sid',
                'jumlah_siswa'   => 0,
            ]
        );

        // Create default hero sliders
        $defaultSliders = [
            [
                'judul'       => 'SMP Sains Al-Qur\'an Klakah',
                'deskripsi'   => 'Membentuk Generasi Qur\'ani yang Cerdas, Mandiri, dan Berakhlak Mulia.',
                'badge_teks'  => null,
                'tombol_teks' => 'Profil Sekolah',
                'tombol_url'  => '/profil-sekolah',
                'urutan'      => 1,
                'is_active'   => true,
            ],
            [
                'judul'       => 'Integrasi Sains & Al-Qur\'an',
                'deskripsi'   => 'Menggabungkan keunggulan sains modern dengan kedalaman spiritual Al-Qur\'an.',
                'badge_teks'  => null,
                'tombol_teks' => 'Pelajari Kurikulum',
                'tombol_url'  => '/kurikulum',
                'urutan'      => 2,
                'is_active'   => true,
            ],
            [
                'judul'       => 'Wadah Bakat & Prestasi',
                'deskripsi'   => 'Mengasah minat, bakat riset sains, tahfidz Al-Qur\'an, dan ragam ekstrakurikuler unggulan.',
                'badge_teks'  => null,
                'tombol_teks' => 'Lihat Prestasi',
                'tombol_url'  => '/informasi/kategori/prestasi',
                'urutan'      => 3,
                'is_active'   => true,
            ],
        ];

        foreach ($defaultSliders as $slider) {
            HeroSlider::firstOrCreate(['judul' => $slider['judul']], $slider);
        }

        // Create default program unggulan
        $programs = [
            ['nama' => 'Tahfidz Al-Qur\'an', 'deskripsi' => 'Program unggulan menghafal Al-Qur\'an dengan target minimal hafal beberapa juz selama masa studi.', 'ikon' => 'bi-book', 'urutan' => 1],
            ['nama' => 'Sains & Teknologi', 'deskripsi' => 'Pembelajaran sains terpadu dengan pendekatan praktikum dan teknologi modern.', 'ikon' => 'bi-lightbulb', 'urutan' => 2],
            ['nama' => 'Pendidikan Akhlak', 'deskripsi' => 'Pembinaan karakter islami dan akhlak mulia dalam kehidupan sehari-hari.', 'ikon' => 'bi-heart', 'urutan' => 3],
            ['nama' => 'Bahasa Arab & Inggris', 'deskripsi' => 'Pengembangan kemampuan bahasa internasional untuk wawasan global.', 'ikon' => 'bi-globe', 'urutan' => 4],
        ];

        foreach ($programs as $prog) {
            ProgramUnggulan::firstOrCreate(['nama' => $prog['nama']], array_merge($prog, ['is_active' => true]));
        }
    }
}
