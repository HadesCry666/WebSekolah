<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    // Tampilan ekskul (frontend) - kalau nanti mau dipakai lagi untuk list
    public function front()
    {
        $data = Ekstrakurikuler::latest()->get();
        return view('front.ekstrakulikuler', compact('data'));
    }

    // >>> HALAMAN DETAIL SATU EKSKUL <<<
    public function detail($id)
    {
        $item = Ekstrakurikuler::findOrFail($id);

        // kirim $item ke view detail
        return view('front.ekstrakulikuler', compact('item'));
    }

    // Halaman CRUD
      public function crud()
        {
            $data = Ekstrakurikuler::latest()->get();
            return view('back.crud_ekstrakulikuler', compact('data'));
        }


    // Store data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'      => 'nullable|string',
            'deskripsi'  => 'nullable|string',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = \App\Helpers\UploadHelper::uploadImage($request->file('gambar'), 'ekskul', 1000, 750);
        }

        Ekstrakurikuler::create($validated);

        return back()->with('success', 'Berhasil menambah ekstrakurikuler.');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $data = Ekstrakurikuler::findOrFail($id);

        $validated = $request->validate([
            'judul'      => 'nullable|string',
            'deskripsi'  => 'nullable|string',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            \App\Helpers\UploadHelper::deleteImage($data->gambar);
            $validated['gambar'] = \App\Helpers\UploadHelper::uploadImage($request->file('gambar'), 'ekskul', 1000, 750);
        }

        $data->update($validated);

        return back()->with('success', 'Berhasil mengupdate ekstrakurikuler.');
    }

    // Hapus data
    public function delete($id)
    {
        $data = Ekstrakurikuler::findOrFail($id);

        \App\Helpers\UploadHelper::deleteImage($data->gambar);

        $data->delete();

        return back()->with('success', 'Berhasil menghapus ekstrakurikuler.');
    }
}
