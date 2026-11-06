<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Tenaga_pendidik;
use App\Models\Ekstrakurikuler;
use App\Models\HeroSlider;
use App\Models\ProfilSekolah;
use App\Models\ProgramUnggulan;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Agenda;
use App\Models\Pengumuman;
use App\Models\Prestasi;

class LandingController extends Controller
{
    public function index()
    {
        // Profil Sekolah & Kepala Sekolah
        $profil = ProfilSekolah::first();
        $kepsek = Tenaga_pendidik::where('jabatan', 'like', '%kepala%sekolah%')->first();

        // Hero Sliders (from database, fallback to hardcoded if empty)
        $sliders = HeroSlider::active()->ordered()->get();

        // Artikel/Berita terbaru
        $artikel = Artikel::latest()->take(6)->get();

        // Kelompok tenaga pendidik
        $guru = Tenaga_pendidik::where('jabatan', 'guru')
                ->orderBy('nama')
                ->get();

        $tataUsaha = Tenaga_pendidik::where(function($q) {
                $q->where('jabatan', 'tata_usaha')
                  ->orWhere('jabatan', 'Tata usaha')
                  ->orWhere('jabatan', 'Tata Usaha');
            })
            ->orderBy('nama')
            ->get();

        $ustadz = Tenaga_pendidik::where('jabatan', 'ustadz')
                ->orderBy('nama')
                ->get();

        // Ekstrakurikuler
        $ekskul = Ekstrakurikuler::latest()->get();

        // Program Unggulan
        $programUnggulan = ProgramUnggulan::active()->ordered()->get();

        // Fasilitas
        $fasilitas = Fasilitas::active()->ordered()->get();

        // Galeri
        $galeri = Galeri::active()->latest()->take(8)->get();

        // Agenda mendatang
        $agenda = Agenda::active()->upcoming()->orderBy('tanggal_mulai')->take(5)->get();

        // Pengumuman aktif
        $pengumuman = Pengumuman::active()->published()->latest('tanggal_publikasi')->take(5)->get();

        // Prestasi
        $prestasi = Prestasi::active()->latest()->take(6)->get();

        // Statistik sekolah
        $statsSekolah = (object)[
            'guru'  => Tenaga_pendidik::count(),
            'siswa' => $profil->jumlah_siswa ?? 0,
        ];

        return view('front.landing', compact(
            'profil',
            'kepsek',
            'sliders',
            'artikel',
            'guru',
            'tataUsaha',
            'ustadz',
            'statsSekolah',
            'ekskul',
            'programUnggulan',
            'fasilitas',
            'galeri',
            'agenda',
            'pengumuman',
            'prestasi'
        ));
    }
}
