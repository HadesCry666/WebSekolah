<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    // ADMIN
    public function index()
    {
        $data = Galeri::latest()->get();
        return view('back.crud_galeri', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe'      => 'required|in:foto,video',
            'file'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'url_video' => 'nullable|url|max:500',
            'kategori'  => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'tipe', 'url_video', 'kategori']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('file')) {
            $data['file'] = \App\Helpers\UploadHelper::uploadImage($request->file('file'), 'galeri', 1200, 900);
        }

        Galeri::create($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = Galeri::findOrFail($id);

        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe'      => 'required|in:foto,video',
            'file'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'url_video' => 'nullable|url|max:500',
            'kategori'  => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'tipe', 'url_video', 'kategori']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('file')) {
            \App\Helpers\UploadHelper::deleteImage($item->file);
            $data['file'] = \App\Helpers\UploadHelper::uploadImage($request->file('file'), 'galeri', 1200, 900);
        }

        $item->update($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Galeri::findOrFail($id);

        \App\Helpers\UploadHelper::deleteImage($item->file);

        $item->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }

    // FRONTEND
    public function frontIndex()
    {
        $foto  = Galeri::active()->foto()->latest()->paginate(12);
        $video = Galeri::active()->video()->latest()->get();

        return view('front.galeri', compact('foto', 'video'));
    }
}
