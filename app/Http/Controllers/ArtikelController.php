<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /* ===========================================================
       FRONTEND – HALAMAN PENGUNJUNG WEBSITE
    ============================================================ */

    // Halaman "Semua Informasi"
    public function informasiAll()
    {
        $artikel = Artikel::latest()->paginate(9);

        $judulHalaman = 'Informasi, Berita & Prestasi';
        $subjudul     = 'Informasi, berita & prestasi siswa';
        $mode         = 'semua';

        return view('front.informasi', compact(
            'artikel',
            'judulHalaman',
            'subjudul',
            'mode'
        ));
    }

    // Halaman per kategori (berita / prestasi)
    public function informasiByKategori($kategori)
    {
        if (!in_array($kategori, ['berita', 'prestasi'])) {
            abort(404);
        }

        $artikel = Artikel::where('kategori', $kategori)
            ->latest()
            ->paginate(9);

        if ($kategori === 'berita') {
            $judulHalaman = 'Berita Sekolah';
            $subjudul     = 'Informasi & berita seputar SMPN Sains Al-Qur\'an Klakah';
        } else {
            $judulHalaman = 'Prestasi Siswa';
            $subjudul     = 'Prestasi akademik maupun non-akademik siswa';
        }

        $mode = $kategori;

        return view('front.informasi', compact(
            'artikel',
            'judulHalaman',
            'subjudul',
            'mode'
        ));
    }

    // Halaman Detail Informasi
    public function detail($id)
    {
        $item = Artikel::findOrFail($id);

        $judulHalaman = $item->judul;

        if ($item->kategori === 'berita') {
            $subjudul = 'Berita sekolah SMPN Sains Al-Qur\'an Klakah';
        } elseif ($item->kategori === 'prestasi') {
            $subjudul = 'Detail prestasi siswa SMPN Sains Al-Qur\'an Klakah';
        } else {
            $subjudul = 'Informasi sekolah';
        }

        return view('front.informasi_detail', compact(
            'item',
            'judulHalaman',
            'subjudul'
        ));
    }
}
