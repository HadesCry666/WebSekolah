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
        $profil = ProfilSekolah::first();
        $kepsek = \App\Models\Tenaga_pendidik::where('jabatan', 'like', '%kepala%sekolah%')->first();
        return view('front.profil_sekolah', compact('profil', 'kepsek'));
    }

    // ADMIN – form edit profil
    public function edit()
    {
        $profil = ProfilSekolah::first();

        if (!$profil) {
            $profil = ProfilSekolah::create([
                'nama_sekolah' => 'SMP Sains Al-Qur\'an Klakah',
            ]);
        }

        return view('back.crud_profil_sekolah', compact('profil'));
    }

    // ADMIN – proses update
    public function update(Request $request)
    {
        $profil = ProfilSekolah::firstOrFail();

        $validated = $request->validate([
            'nama_sekolah'      => 'nullable|string|max:255',
            'npsn'              => 'nullable|string|max:50',
            'akreditasi'        => 'nullable|string|max:10',
            'tahun_berdiri'     => 'nullable|integer|min:1900|max:2100',
            'jumlah_siswa'      => 'nullable|integer|min:0',
            'tagline'           => 'nullable|string|max:255',
            'deskripsi'         => 'nullable|string',
            'sejarah'           => 'nullable|string',
            'visi'              => 'nullable|string',
            'misi'              => 'nullable|string',
            'nama_kepsek'       => 'nullable|string|max:255',
            'sambutan_kepsek'   => 'nullable|string',
            'alamat'            => 'nullable|string|max:255',
            'telepon'           => 'nullable|string|max:50',
            'email'             => 'nullable|email|max:100',
            'whatsapp'          => 'nullable|string|max:50',
            'instagram'         => 'nullable|string|max:255',
            'youtube'           => 'nullable|string|max:255',
            'facebook'          => 'nullable|string|max:255',
            'maps_embed'        => 'nullable|string',
            'meta_description'  => 'nullable|string|max:160',
            'gambar'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'favicon'           => 'nullable|image|mimes:jpg,jpeg,png,ico,svg|max:1024',
            'foto_kepsek'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle file uploads
        $imageFields = ['gambar', 'logo', 'favicon', 'foto_kepsek'];
        $storeFolders = [
            'gambar'      => 'profil_sekolah',
            'logo'        => 'profil_sekolah',
            'favicon'     => 'profil_sekolah',
            'foto_kepsek' => 'profil_sekolah',
        ];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file
                if ($profil->$field && Storage::disk('public')->exists($profil->$field)) {
                    Storage::disk('public')->delete($profil->$field);
                }
                $validated[$field] = $request->file($field)->store($storeFolders[$field], 'public');
            } else {
                unset($validated[$field]);
            }
        }

        if (!$request->filled('nama_kepsek')) {
            unset($validated['nama_kepsek']);
        }

        $profil->update($validated);

        return back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
