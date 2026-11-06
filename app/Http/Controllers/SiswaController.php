<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    // ─────────────────────────────────────────────
    // INDEX
    // ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Siswa::query();

        // Filter pencarian
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Filter kelas
        if ($kelas = $request->input('kelas')) {
            $query->where('kelas', $kelas);
        }

        // Filter status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter jenis kelamin
        if ($jk = $request->input('jk')) {
            $query->where('jenis_kelamin', $jk);
        }

        $perPage = (int) $request->input('per_page', 15);
        $siswa   = $query->orderBy('kelas')->orderBy('nama')->paginate($perPage)->withQueryString();
        $kelas   = Siswa::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        // Stats
        $stats = [
            'total'  => Siswa::count(),
            'aktif'  => Siswa::where('status', 'aktif')->count(),
            'laki'   => Siswa::where('jenis_kelamin', 'L')->count(),
            'perempuan' => Siswa::where('jenis_kelamin', 'P')->count(),
        ];

        return view('back.crud_siswa', compact('siswa', 'kelas', 'stats'));
    }

    // ─────────────────────────────────────────────
    // STORE
    // ─────────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'nis'            => 'required|string|max:20|unique:siswas,nis',
            'nisn'           => 'nullable|string|max:20|unique:siswas,nisn',
            'nik'            => 'nullable|string|max:25',
            'nama'           => 'required|string|max:100',
            'kelas'          => 'nullable|string|max:20',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'nullable|string|max:50',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',
            'nama_wali'      => 'nullable|string|max:100',
            'kontak_wali'    => 'nullable|string|max:20',
            'status'         => 'required|in:aktif,alumni,pindah,keluar',
            'foto'           => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        Siswa::create($data);

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────────
    // UPDATE
    // ─────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $data = $request->validate([
            'nis'            => 'required|string|max:20|unique:siswas,nis,'.$id,
            'nisn'           => 'nullable|string|max:20|unique:siswas,nisn,'.$id,
            'nik'            => 'nullable|string|max:25',
            'nama'           => 'required|string|max:100',
            'kelas'          => 'nullable|string|max:20',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'nullable|string|max:50',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',
            'nama_wali'      => 'nullable|string|max:100',
            'kontak_wali'    => 'nullable|string|max:20',
            'status'         => 'required|in:aktif,alumni,pindah,keluar',
            'foto'           => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($data);

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Data siswa berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────
    // DESTROY
    // ─────────────────────────────────────────────
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Data siswa berhasil dihapus.');
    }

    // ─────────────────────────────────────────────
    // IMPORT EXCEL / CSV
    // ─────────────────────────────────────────────
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ]);

        $file      = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());

        // Jika file xlsx/xls — gunakan PhpSpreadsheet jika tersedia, fallback ke pesan error
        if (in_array($extension, ['xlsx', 'xls'])) {
            return $this->importExcel($file);
        }

        // CSV import langsung
        return $this->importCsv($file->getRealPath());
    }

    private function importExcel($file)
    {
        // Coba gunakan maatwebsite/excel bila tersedia
        if (class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
            $data = \Maatwebsite\Excel\Facades\Excel::toArray(new \stdClass, $file);
            $rows = $data[0] ?? [];
        } elseif (class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $rows = $spreadsheet->getActiveSheet()->toArray();
        } else {
            return redirect()->route('admin.siswa.index')
                             ->with('error', 'Format Excel tidak didukung. Gunakan file CSV.');
        }

        return $this->processRows($rows);
    }

    private function importCsv(string $path)
    {
        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $rows[] = $row;
            }
            fclose($handle);
        }
        return $this->processRows($rows);
    }

    private function processRows(array $rows)
    {
        // Baris pertama = header, skip
        $header  = array_shift($rows);
        $success = 0;
        $skip    = 0;
        $errors  = [];

        foreach ($rows as $i => $row) {
            // Lewati baris kosong
            if (empty(array_filter($row))) continue;

            try {
                // Mapping kolom: NIS | Nama | Kelas | JK | Tempat Lahir | Tgl Lahir | Alamat | Nama Wali | Kontak Wali | Status
                $nis  = trim($row[0] ?? '');
                $nama = trim($row[1] ?? '');

                if (!$nis || !$nama) { $skip++; continue; }

                Siswa::updateOrCreate(
                    ['nis' => $nis],
                    [
                        'nama'           => $nama,
                        'kelas'          => trim($row[2] ?? ''),
                        'jenis_kelamin'  => strtoupper(trim($row[3] ?? 'L')) === 'P' ? 'P' : 'L',
                        'tempat_lahir'   => trim($row[4] ?? ''),
                        'tanggal_lahir'  => $this->parseDate($row[5] ?? ''),
                        'alamat'         => trim($row[6] ?? ''),
                        'nama_wali'      => trim($row[7] ?? ''),
                        'kontak_wali'    => trim($row[8] ?? ''),
                        'status'         => $this->parseStatus($row[9] ?? 'aktif'),
                    ]
                );
                $success++;
            } catch (\Exception $e) {
                $errors[] = "Baris ".($i + 2).": ".$e->getMessage();
                $skip++;
            }
        }

        $msg = "Import selesai: {$success} siswa berhasil diimpor.";
        if ($skip) $msg .= " {$skip} baris dilewati.";
        if ($errors) $msg .= " Error: ".implode('; ', array_slice($errors, 0, 3));

        $type = $errors ? 'warning' : 'success';
        return redirect()->route('admin.siswa.index')->with($type, $msg);
    }

    private function parseDate($val): ?string
    {
        if (!$val) return null;
        $val = trim($val);

        // Format numerik dari Excel (nomor serial)
        if (is_numeric($val)) {
            try {
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float)$val);
                return $date->format('Y-m-d');
            } catch (\Exception $e) {}
        }

        // Coba parse tanggal string
        try {
            return \Carbon\Carbon::parse($val)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseStatus(string $val): string
    {
        $val = strtolower(trim($val));
        $map = ['aktif' => 'aktif', 'alumni' => 'alumni', 'pindah' => 'pindah', 'keluar' => 'keluar'];
        return $map[$val] ?? 'aktif';
    }

    // ─────────────────────────────────────────────
    // DOWNLOAD TEMPLATE CSV
    // ─────────────────────────────────────────────
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_import_siswa.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            // Header
            fputcsv($handle, [
                'NIS', 'Nama Lengkap', 'Kelas', 'Jenis Kelamin (L/P)',
                'Tempat Lahir', 'Tanggal Lahir (YYYY-MM-DD)', 'Alamat',
                'Nama Wali', 'Kontak Wali', 'Status (aktif/alumni/pindah/keluar)',
            ]);

            // Contoh data
            fputcsv($handle, ['2024001', 'Ahmad Fauzi', '7A', 'L', 'Lumajang', '2011-05-14', 'Jl. Merdeka No. 1', 'Bapak Fauzan', '08123456789', 'aktif']);
            fputcsv($handle, ['2024002', 'Siti Nurhaliza', '7A', 'P', 'Lumajang', '2011-08-22', 'Jl. Pahlawan No. 5', 'Ibu Fatimah', '08987654321', 'aktif']);

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
