<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use App\Models\ProfilSekolah;
use App\Models\ProgramUnggulan;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    // =======================================================
    // FRONTEND: Halaman Kurikulum & Pembelajaran
    // =======================================================
    public function index()
    {
        $profil = ProfilSekolah::first();
        $programUnggulan = ProgramUnggulan::active()->ordered()->get();

        $pengantar = Kurikulum::byType('pengantar')->first();
        $pilars = Kurikulum::byType('pilar')->active()->ordered()->get();
        $mapelUmum = Kurikulum::byType('mapel')->byCategory('umum')->active()->ordered()->get();
        $mapelIslam = Kurikulum::byType('mapel')->byCategory('islam')->active()->ordered()->get();
        $mapelSains = Kurikulum::byType('mapel')->byCategory('sains')->active()->ordered()->get();
        $capaians = Kurikulum::byType('capaian')->active()->ordered()->get();

        return view('front.kurikulum', compact(
            'profil',
            'programUnggulan',
            'pengantar',
            'pilars',
            'mapelUmum',
            'mapelIslam',
            'mapelSains',
            'capaians'
        ));
    }

    // =======================================================
    // ADMIN: Halaman Pengelolaan Kurikulum
    // =======================================================
    public function adminIndex(Request $request)
    {
        $tab = $request->input('tab', 'pilar');

        $pengantar = Kurikulum::byType('pengantar')->first();
        $pilars = Kurikulum::byType('pilar')->ordered()->get();
        $mapels = Kurikulum::byType('mapel')->ordered()->get();
        $capaians = Kurikulum::byType('capaian')->ordered()->get();

        $stats = [
            'total'   => Kurikulum::where('tipe', '!=', 'pengantar')->count(),
            'pilar'   => Kurikulum::byType('pilar')->count(),
            'mapel'   => Kurikulum::byType('mapel')->count(),
            'capaian' => Kurikulum::byType('capaian')->count(),
        ];

        return view('back.crud_kurikulum', compact(
            'tab',
            'pengantar',
            'pilars',
            'mapels',
            'capaians',
            'stats'
        ));
    }

    // =======================================================
    // ADMIN: Tambah Item Kurikulum
    // =======================================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe'      => 'required|in:pilar,mapel,capaian',
            'kategori'  => 'nullable|string|max:50',
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'ikon'      => 'nullable|string|max:100',
            'poin_poin' => 'nullable|string',
            'urutan'    => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        Kurikulum::create($validated);

        return redirect()->route('admin.kurikulum.index', ['tab' => $validated['tipe']])
            ->with('success', 'Data kurikulum berhasil ditambahkan.');
    }

    // =======================================================
    // ADMIN: Update Item Kurikulum
    // =======================================================
    public function update(Request $request, $id)
    {
        $item = Kurikulum::findOrFail($id);

        $validated = $request->validate([
            'tipe'      => 'required|in:pilar,mapel,capaian',
            'kategori'  => 'nullable|string|max:50',
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'ikon'      => 'nullable|string|max:100',
            'poin_poin' => 'nullable|string',
            'urutan'    => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $item->update($validated);

        return redirect()->route('admin.kurikulum.index', ['tab' => $item->tipe])
            ->with('success', 'Data kurikulum berhasil diperbarui.');
    }

    // =======================================================
    // ADMIN: Update Header & Pengantar Kurikulum
    // =======================================================
    public function updatePengantar(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'poin_poin' => 'nullable|string|max:100', // badge text
            'ikon'      => 'nullable|string|max:100',
        ]);

        Kurikulum::updateOrCreate(
            ['tipe' => 'pengantar', 'kategori' => 'hero'],
            [
                'judul'     => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'poin_poin' => $validated['poin_poin'] ?? 'Sistem Pendidikan Terpadu',
                'ikon'      => $validated['ikon'] ?? 'bi-book-half',
                'urutan'    => 1,
                'is_active' => true,
            ]
        );

        return redirect()->route('admin.kurikulum.index', ['tab' => 'pengantar'])
            ->with('success', 'Pengantar kurikulum berhasil diperbarui.');
    }

    // =======================================================
    // ADMIN: Toggle Status Aktif
    // =======================================================
    public function toggleActive($id)
    {
        $item = Kurikulum::findOrFail($id);
        $item->is_active = !$item->is_active;
        $item->save();

        return back()->with('success', 'Status "' . $item->judul . '" berhasil diubah.');
    }

    // =======================================================
    // ADMIN: Hapus Item Kurikulum
    // =======================================================
    public function destroy($id)
    {
        $item = Kurikulum::findOrFail($id);
        $tipe = $item->tipe;
        $item->delete();

        return redirect()->route('admin.kurikulum.index', ['tab' => $tipe])
            ->with('success', 'Data kurikulum berhasil dihapus.');
    }
}
