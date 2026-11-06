<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Tenaga_pendidik;
use App\Models\Ekstrakurikuler;
use App\Models\HeroSlider;
use App\Models\ProgramUnggulan;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Agenda;
use App\Models\Pengumuman;
use App\Models\Prestasi;
use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'artikel'       => Artikel::count(),
            'guru'          => Tenaga_pendidik::count(),
            'ekskul'        => Ekstrakurikuler::count(),
            'slider'        => HeroSlider::count(),
            'program'       => ProgramUnggulan::count(),
            'fasilitas'     => Fasilitas::count(),
            'galeri'        => Galeri::count(),
            'agenda'        => Agenda::count(),
            'pengumuman'    => Pengumuman::count(),
            'prestasi'      => Prestasi::count(),
            'pengaduan'     => Pengaduan::count(),
            'pengaduan_baru'=> Pengaduan::where('status', 'baru')->count(),
        ];

        $artikelTerbaru   = Artikel::latest()->take(5)->get();
        $pengaduanBaru    = Pengaduan::latest()->take(5)->get();
        $agendaMendatang  = Agenda::active()->upcoming()->orderBy('tanggal_mulai')->take(5)->get();

        return view('back.dashboard', compact('stats', 'artikelTerbaru', 'pengaduanBaru', 'agendaMendatang'));
    }
}
