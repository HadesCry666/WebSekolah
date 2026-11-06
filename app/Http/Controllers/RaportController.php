<?php

namespace App\Http\Controllers;

use App\Models\Raport;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RaportController extends Controller
{
    /**
     * Tampilkan halaman manajemen raport siswa
     */
    public function index(Request $request)
    {
        $currentYear = date('Y');
        $prevYear    = $currentYear - 1;
        $nextYear    = $currentYear + 1;

        // Default list tahun ajaran
        $tahunAjaranList = [
            "{$currentYear}/{$nextYear}",
            "{$prevYear}/{$currentYear}",
            ($currentYear - 2) . "/{$prevYear}",
        ];

        // Filter aktif
        $tahunAjaranAktif = $request->input('tahun_ajaran', $tahunAjaranList[0]);
        $semesterAktif    = $request->input('semester', 'ganjil');
        $kelasAktif       = $request->input('kelas', '');
        $search           = $request->input('search', '');

        // Query siswa
        $siswaQuery = Siswa::query()->where('status', 'aktif');

        if ($kelasAktif) {
            $siswaQuery->where('kelas', $kelasAktif);
        }

        if ($search) {
            $siswaQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Ambil daftar kelas untuk dropdown filter
        $kelasList = Siswa::select('kelas')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        // Eager load raport spesifik untuk periode terpilih
        $siswa = $siswaQuery->with(['raports' => function ($q) use ($tahunAjaranAktif, $semesterAktif) {
            $q->where('tahun_ajaran', $tahunAjaranAktif)
              ->where('semester', $semesterAktif);
        }, 'user'])->orderBy('kelas')->orderBy('nama')->paginate(20)->withQueryString();

        // Hitung statistik raport periode ini
        $totalSiswaAktif = Siswa::where('status', 'aktif')->count();
        $totalRaportUploaded = Raport::where('tahun_ajaran', $tahunAjaranAktif)
            ->where('semester', $semesterAktif)
            ->count();
        $totalPublished = Raport::where('tahun_ajaran', $tahunAjaranAktif)
            ->where('semester', $semesterAktif)
            ->where('is_published', true)
            ->count();
        $totalAkunSiswa = User::where('role', 'siswa')->count();

        $stats = [
            'total_siswa'   => $totalSiswaAktif,
            'sudah_upload'  => $totalRaportUploaded,
            'belum_upload'  => max(0, $totalSiswaAktif - $totalRaportUploaded),
            'published'     => $totalPublished,
            'akun_siswa'    => $totalAkunSiswa,
        ];

        return view('back.raport.index', compact(
            'siswa',
            'kelasList',
            'tahunAjaranList',
            'tahunAjaranAktif',
            'semesterAktif',
            'kelasAktif',
            'search',
            'stats'
        ));
    }

    /**
     * Upload / Update file raport untuk seorang siswa
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'     => 'required|exists:siswas,id',
            'tahun_ajaran' => 'required|string|max:20',
            'semester'     => 'required|in:ganjil,genap',
            'file_raport'  => 'required|file|mimes:pdf|max:10240', // Maks 10MB
            'catatan'      => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
        ], [
            'siswa_id.required'     => 'Pilih siswa terlebih dahulu.',
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'semester.required'     => 'Semester wajib dipilih.',
            'file_raport.required'  => 'File raport PDF wajib diunggah.',
            'file_raport.mimes'     => 'Format file raport harus PDF.',
            'file_raport.max'       => 'Ukuran file raport maksimal 10MB.',
        ]);

        $siswa = Siswa::findOrFail($request->siswa_id);

        // Cek apakah raport sudah pernah diupload untuk siswa & periode ini
        $existing = Raport::where('siswa_id', $siswa->id)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->where('semester', $request->semester)
            ->first();

        // Simpan file ke storage privat (storage/app/raports/...)
        $file = $request->file('file_raport');
        $namaFileAsli = $file->getClientOriginalName();
        $sanitizedTahun = str_replace('/', '-', $request->tahun_ajaran);
        $folder = "raports/{$sanitizedTahun}/{$request->semester}";
        $path = $file->store($folder);

        if ($existing) {
            // Hapus file lama jika ada
            if ($existing->file_raport && Storage::exists($existing->file_raport)) {
                Storage::delete($existing->file_raport);
            }

            $existing->update([
                'file_raport'    => $path,
                'nama_file_asli' => $namaFileAsli,
                'is_published'   => $request->boolean('is_published', true),
                'catatan'        => $request->input('catatan'),
            ]);

            $message = "Raport {$siswa->nama} berhasil diperbarui.";
        } else {
            Raport::create([
                'siswa_id'       => $siswa->id,
                'tahun_ajaran'   => $request->tahun_ajaran,
                'semester'       => $request->semester,
                'file_raport'    => $path,
                'nama_file_asli' => $namaFileAsli,
                'is_published'   => $request->boolean('is_published', true),
                'catatan'        => $request->input('catatan'),
            ]);

            $message = "Raport {$siswa->nama} berhasil diunggah.";
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Download file raport (Khusus Admin)
     */
    public function download($id)
    {
        $raport = Raport::with('siswa')->findOrFail($id);

        if (!Storage::exists($raport->file_raport)) {
            return redirect()->back()->with('error', 'File raport tidak ditemukan di server.');
        }

        $namaFileDownload = "Raport_{$raport->siswa->nis}_{$raport->siswa->nama}_{$raport->semester}_{$raport->tahun_ajaran}.pdf";
        $namaFileDownload = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $namaFileDownload);

        return Storage::download($raport->file_raport, $namaFileDownload);
    }

    /**
     * Preview file raport di browser tab (Khusus Admin)
     */
    public function preview($id)
    {
        $raport = Raport::with('siswa')->findOrFail($id);

        if (!Storage::exists($raport->file_raport)) {
            abort(404, 'File raport tidak ditemukan.');
        }

        $path = Storage::path($raport->file_raport);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Raport-' . $raport->siswa->nis . '.pdf"',
        ]);
    }

    /**
     * Hapus file raport
     */
    public function destroy($id)
    {
        $raport = Raport::with('siswa')->findOrFail($id);
        $nama = $raport->siswa->nama ?? 'Siswa';

        if ($raport->file_raport && Storage::exists($raport->file_raport)) {
            Storage::delete($raport->file_raport);
        }

        $raport->delete();

        return redirect()->back()->with('success', "Raport milik {$nama} berhasil dihapus.");
    }

    /**
     * Toggle status publish raport (bisa dilihat siswa atau ditahan dulu)
     */
    public function togglePublish($id)
    {
        $raport = Raport::findOrFail($id);
        $raport->is_published = !$raport->is_published;
        $raport->save();

        $statusText = $raport->is_published ? 'dipublikasikan (dapat didownload siswa)' : 'disembunyikan (draft)';
        return redirect()->back()->with('success', "Status raport berhasil diubah: {$statusText}.");
    }

    /**
     * Otomatis buat / reset akun login siswa untuk yang belum memiliki akun
     */
    public function generateAkunSiswa(Request $request)
    {
        $kelas = $request->input('kelas');

        $siswaQuery = Siswa::query()->where('status', 'aktif');
        if ($kelas) {
            $siswaQuery->where('kelas', $kelas);
        }

        $siswas = $siswaQuery->get();
        $created = 0;
        $skipped = 0;

        foreach ($siswas as $item) {
            // Gunakan NISN sebagai username, jika belum ada gunakan NIS
            $username = $item->nisn ?: $item->nis;
            // Gunakan NIK sebagai password default, jika belum ada gunakan NISN/NIS
            $rawPassword = $item->nik ?: ($item->nisn ?: $item->nis);

            $existingUser = User::where('siswa_id', $item->id)
                ->orWhere('username', $username)
                ->orWhere('username', $item->nis)
                ->first();

            if (!$existingUser) {
                $syntheticEmail = "siswa.{$username}@smp.sch.id";

                User::create([
                    'name'     => $item->nama,
                    'username' => $username,
                    'email'    => $syntheticEmail,
                    'password' => Hash::make($rawPassword),
                    'role'     => 'siswa',
                    'siswa_id' => $item->id,
                ]);

                $created++;
            } else {
                $existingUser->update([
                    'name'     => $item->nama,
                    'username' => $username,
                    'password' => Hash::make($rawPassword),
                    'role'     => 'siswa',
                    'siswa_id' => $item->id,
                ]);
                $skipped++;
            }
        }

        return redirect()->back()->with('success', "Selesai! Akun siswa berhasil disinkronisasi ({$created} baru, {$skipped} diperbarui). Username: NISN, Password: NIK.");
    }
}
