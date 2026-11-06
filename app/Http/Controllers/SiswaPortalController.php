<?php

namespace App\Http\Controllers;

use App\Models\Raport;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiswaPortalController extends Controller
{
    /**
     * Dashboard & Halaman Download Raport Siswa
     */
    public function index()
    {
        $user = Auth::user();

        // Cari data siswa yang terhubung dengan akun ini
        $siswa = $user->siswa;

        if (!$siswa && $user->username) {
            $siswa = Siswa::where('nis', $user->username)->first();
            if ($siswa) {
                $user->update(['siswa_id' => $siswa->id]);
            }
        }

        if (!$siswa) {
            return view('front.siswa.raport', [
                'siswa'   => null,
                'raports' => collect(),
                'error'   => 'Akun Anda belum terhubung dengan data siswa manapun. Harap hubungi pihak sekolah / admin.',
            ]);
        }

        // Ambil raport yang sudah dipublikasikan saja
        $raports = Raport::where('siswa_id', $siswa->id)
            ->where('is_published', true)
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        return view('front.siswa.raport', compact('siswa', 'raports'));
    }

    /**
     * Download file raport (Khusus Siswa yang bersangkutan)
     */
    public function downloadRaport($id)
    {
        $user = Auth::user();
        $raport = Raport::with('siswa')->findOrFail($id);

        // Keamanan ketat: Hanya pemilik raport yang boleh mendownload
        if ($raport->siswa_id !== $user->siswa_id) {
            abort(403, 'Anda tidak berhak mengakses raport siswa lain.');
        }

        // Pastikan sudah dipublish
        if (!$raport->is_published) {
            abort(403, 'Raport ini belum dipublikasikan oleh pihak sekolah.');
        }

        if (!Storage::exists($raport->file_raport)) {
            return redirect()->back()->with('error', 'File raport belum tersedia atau telah dipindahkan.');
        }

        $namaFile = "Raport_{$raport->siswa->nis}_{$raport->semester}_{$raport->tahun_ajaran}.pdf";
        $namaFile = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $namaFile);

        return Storage::download($raport->file_raport, $namaFile);
    }

    /**
     * Preview file raport di browser (Khusus Siswa yang bersangkutan)
     */
    public function previewRaport($id)
    {
        $user = Auth::user();
        $raport = Raport::with('siswa')->findOrFail($id);

        if ($raport->siswa_id !== $user->siswa_id) {
            abort(403, 'Akses ditolak.');
        }

        if (!$raport->is_published) {
            abort(403, 'Raport belum dipublikasikan.');
        }

        if (!Storage::exists($raport->file_raport)) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = Storage::path($raport->file_raport);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Raport.pdf"',
        ]);
    }
}
