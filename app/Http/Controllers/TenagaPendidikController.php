<?php

namespace App\Http\Controllers;

use App\Models\Tenaga_pendidik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenagaPendidikController extends Controller
{
    // =============== FRONTEND: HALAMAN DAFTAR GURU ===============
  public function frontIndex()
{
    // guru
    $guru = Tenaga_pendidik::where('jabatan', 'guru')
        ->orderBy('nama')
        ->get();

    // tata usaha
    $tataUsaha = Tenaga_pendidik::where(function($q) {
            $q->where('jabatan', 'tata_usaha')
              ->orWhere('jabatan', 'Tata usaha')
              ->orWhere('jabatan', 'Tata Usaha');
        })
        ->orderBy('nama')
        ->get();

    // ustadz
    $ustadz = Tenaga_pendidik::where('jabatan', 'ustadz')
        ->orderBy('nama')
        ->get();

    return view('front.tenaga_pendidik', compact('guru', 'tataUsaha', 'ustadz'));
}


    // =============== ADMIN: HALAMAN CRUD GURU ===============
    public function adminIndex(Request $request)
    {
        $query = Tenaga_pendidik::query();

        // Filter pencarian
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('NIP', 'like', "%{$search}%")
                  ->orWhere('mata_pelajaran', 'like', "%{$search}%");
            });
        }

        // Filter jabatan
        if ($jabatan = $request->input('jabatan')) {
            if (in_array(strtolower(str_replace(' ', '_', $jabatan)), ['tata_usaha', 'tatausaha'])) {
                $query->where(function($q) {
                    $q->where('jabatan', 'like', '%tata%');
                });
            } else {
                $query->where('jabatan', $jabatan);
            }
        }

        $perPage = (int) $request->input('per_page', 15);
        $data = $query->latest()->paginate($perPage)->withQueryString();

        // Stats menyeluruh
        $stats = [
            'total'      => Tenaga_pendidik::count(),
            'guru'       => Tenaga_pendidik::where('jabatan', 'Guru')->count(),
            'tata_usaha' => Tenaga_pendidik::where(function($q) {
                $q->where('jabatan', 'like', '%tata%');
            })->count(),
            'ustadz'     => Tenaga_pendidik::where('jabatan', 'Ustadz')->count(),
        ];

        return view('back.crud_tenaga_pendidik', compact('data', 'stats'));
    }

    // SIMPAN DATA BARU
public function store(Request $request)
{
    // VALIDASI
    $validated = $request->validate([
        'nama'          => 'required|string|max:255',
        'jabatan'       => 'required|in:Guru,Tata usaha,Tata Usaha,tata_usaha,Ustadz',
        'mata_pelajaran'         => 'nullable|string|max:255',
        'NIP'           => 'nullable|string|max:100',
        'pendidikan_terakhir'    => 'nullable|string|max:100',
        'agama'         => 'nullable|string|max:50',
        'tempat_lahir'  => 'nullable|string|max:100',
        'tanggal_lahir' => 'nullable|date',
        'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
        'alamat'        => 'nullable|string',
        'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // NORMALISASI JABATAN
    $jabatan = $validated['jabatan'];
    if (in_array(strtolower(str_replace(' ', '_', $jabatan)), ['tata_usaha', 'tatausaha'])) {
        $jabatan = 'Tata usaha';
    }

    // HANDLE FOTO (JIKA ADA)
    $fotoPath = null;
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('guru', 'public');
    }

    // SIMPAN KE DATABASE (SESUAI NAMA KOLOM TABEL)
    Tenaga_pendidik::create([
        'nama'                  => $validated['nama'],
        'jabatan'               => $jabatan,
        'mata_pelajaran'        => $validated['mata_pelajaran'] ?? null,
        'NIP'                   => $validated['NIP'] ?? null,
        'pendidikan_terakhir'  => $validated['pendidikan_terakhir'] ?? null,
        'agama'                 => $validated['agama'] ?? null,
        'alamat'                => $validated['alamat'] ?? null,
        'tempat_lahir'          => $validated['tempat_lahir'] ?? null,
        'tanggal_lahir'         => $validated['tanggal_lahir'] ?? null,
        'jenis_kelamin'         => $validated['jenis_kelamin'] ?? null,
        'foto'                  => $fotoPath,
    ]);

    return redirect()->route('admin.tenaga-pendidik.index')
        ->with('success', 'Data tenaga pendidik berhasil ditambahkan.');
}



public function update(Request $request, $id)
{
    $guru = Tenaga_pendidik::findOrFail($id);

    $validated = $request->validate([
        'nama'          => 'required|string|max:255',
        'jabatan'       => 'required|in:Guru,Tata usaha,Tata Usaha,tata_usaha,Ustadz', 
        'mata_pelajaran'         => 'nullable|string|max:255',
        'NIP'           => 'nullable|string|max:100',
        'pendidikan_terakhir'    => 'nullable|string|max:100',
        'agama'         => 'nullable|string|max:50',
        'tempat_lahir'  => 'nullable|string|max:100',
        'tanggal_lahir' => 'nullable|date',
        'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
        'alamat'        => 'nullable|string',
        'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $jabatan = $validated['jabatan'];
    if (in_array(strtolower(str_replace(' ', '_', $jabatan)), ['tata_usaha', 'tatausaha'])) {
        $jabatan = 'Tata usaha';
    }

        $dataUpdate = [
            'nama'                  => $request->nama,
            'jabatan'               => $jabatan,
            'mata_pelajaran'        => $request->mata_pelajaran,
            'NIP'                   => $request->NIP,
            'pendidikan_terakhir'  => $request->pendidikan_terakhir,
            'agama'                 => $request->agama,
            'alamat'                => $request->alamat,
            'tempat_lahir'          => $request->tempat_lahir,
            'tanggal_lahir'         => $request->tanggal_lahir,
            'jenis_kelamin'         => $request->jenis_kelamin,
        ];

        if ($request->hasFile('foto')) {
            // hapus foto lama kalau ada
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }

            $dataUpdate['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru->update($dataUpdate);

        return redirect()->route('admin.tenaga-pendidik.index')
            ->with('success', 'Data tenaga pendidik berhasil diupdate.');
    }

    // HAPUS DATA
    public function destroy($id)
    {
        $guru = Tenaga_pendidik::findOrFail($id);

        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()->route('admin.tenaga-pendidik.index')
            ->with('success', 'Data tenaga pendidik berhasil dihapus.');
    }

    // DETAIL GURU (FRONTEND)
    public function detail($id)
    {
        $guru = Tenaga_pendidik::findOrFail($id);

        return view('front.tenaga_pendidik_detail', compact('guru'));
    }
}
