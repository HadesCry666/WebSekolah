<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    // ================== HALAMAN CRUD (INDEX) ==================
    public function index()
    {
        $data = Artikel::latest()->get();
        return view('back.crud_informasi', compact('data'));
    }


    // ================== SIMPAN DATA BARU ==================
    public function store(Request $request)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'deskripsi_berita' => 'required|string',
            'kategori'         => 'required|in:berita,prestasi',
            'gambar'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $request->file('gambar')->store('artikel', 'public');
        }

        Artikel::create([
            'judul'            => $request->judul,
            'deskripsi_berita' => $request->deskripsi_berita,
            'gambar'           => $pathGambar,
            'kategori'         => $request->kategori,
        ]);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil ditambahkan.');
    }

    // ================== UPDATE DATA ==================
    public function update(Request $request, $id)
    {
        $item = Artikel::findOrFail($id);

        $request->validate([
            'judul'            => 'required|string|max:255',
            'deskripsi_berita' => 'required|string',
            'kategori'         => 'required|in:berita,prestasi',
            'gambar'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $dataUpdate = [
            'judul'            => $request->judul,
            'deskripsi_berita' => $request->deskripsi_berita,
            'kategori'         => $request->kategori,
        ];

        if ($request->hasFile('gambar')) {
            // hapus gambar lama kalau ada
            if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
                Storage::disk('public')->delete($item->gambar);
            }

            $dataUpdate['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        $item->update($dataUpdate);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil diupdate.');
    }

    // ================== HAPUS DATA ==================
    public function destroy($id)
    {
        $item = Artikel::findOrFail($id);

        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil dihapus.');
    }
}
