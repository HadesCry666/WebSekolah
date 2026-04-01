<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Tenaga_pendidik;
use App\Models\Ekstrakurikuler;

class LandingController extends Controller
{
    public function index()
    {
        // Semua artikel (kalau mau dibatasi bisa pakai ->take(6))
        $artikel = Artikel::latest()->get();

        // Kelompok tenaga pendidik
        $guru = Tenaga_pendidik::where('jabatan', 'guru')
                ->orderBy('nama')
                ->get();

        $tataUsaha = Tenaga_pendidik::where('jabatan', 'tata_usaha')
                ->orderBy('nama')
                ->get();

        $ustadz = Tenaga_pendidik::where('jabatan', 'ustadz')
                ->orderBy('nama')
                ->get();

        // 🔹 TAMPILKAN SEMUA EKSKUL DARI DATABASE (urut terbaru dulu)
        $ekskul = Ekstrakurikuler::latest()->get();
        // kalau mau benar-benar semua tanpa peduli urutan:
        // $ekskul = Ekstrakurikuler::all();

        // Statistik sekolah (kalau perlu)
        $statsSekolah = (object)[
            'guru'  => Tenaga_pendidik::count(),
            'siswa' => 500,
        ];

        // Kirim semua data ke landing
        return view('front.landing', compact(
            'artikel',
            'guru',
            'tataUsaha',
            'ustadz',
            'statsSekolah',
            'ekskul'
        ));
    }
}
