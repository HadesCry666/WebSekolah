<?php
namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilSekolahController extends Controller
{
    // FRONT – Profil Sekolah
    public function front()
    {
        $profil = ProfilSekolah::first();   // hanya 1 baris
        return view('front.profil_sekolah', compact('profil'));
    }

    // ADMIN – form edit profil
    public function edit()
    {
        $profil = ProfilSekolah::first();

        // kalau belum ada record, buat kosong dulu
        if (!$profil) {
            $profil = ProfilSekolah::create([]);
        }

        return view('back.crud_profil_sekolah', compact('profil'));
    }

    // ADMIN – proses update
    public function update(Request $request)
    {
        $profil = ProfilSekolah::firstOrFail();

        $validated = $request->validate([
            'nama_sekolah' => 'nullable|string|max:255',
            'tagline'      => 'nullable|string|max:255',
            'deskripsi'    => 'nullable|string',
            'visi'         => 'nullable|string',
            'misi'         => 'nullable|string',
            'alamat'       => 'nullable|string|max:255',
            'telepon'      => 'nullable|string|max:50',
            'email'        => 'nullable|email|max:100',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($profil->gambar && Storage::disk('public')->exists($profil->gambar)) {
                Storage::disk('public')->delete($profil->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('profil_sekolah', 'public');
        }

        $profil->update($validated);

        return back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
