<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    // FRONT – Form pengaduan
    public function front()
    {
        return view('front.pengaduan');
    }

    // Simpan pengaduan dari front
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:100',
            'email'  => 'nullable|email|max:100',
            'no_hp'  => 'nullable|string|max:30',
            'judul'  => 'required|string|max:150',
            'isi'    => 'required|string',
        ]);

        Pengaduan::create($validated);

        return back()->with('success', 'Pengaduan berhasil dikirim. Terima kasih.');
    }

    // ADMIN – list semua pengaduan
    public function adminIndex()
    {
        $data = Pengaduan::latest()->get();
        return view('back.crud_pengaduan', compact('data'));
    }

    // ADMIN – hapus pengaduan
    public function destroy($id)
    {
        $item = Pengaduan::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Pengaduan berhasil dihapus.');
    }
}
