<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    // ADMIN
    public function index()
    {
        $data = Prestasi::latest()->get();
        return view('back.crud_prestasi', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'nullable|string|max:100',
            'tingkat'   => 'nullable|string|max:100',
            'tanggal'   => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['nama', 'kategori', 'tingkat', 'tanggal', 'deskripsi']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('foto')) {
            $data['foto'] = \App\Helpers\UploadHelper::uploadImage($request->file('foto'), 'prestasi', 1000, 750);
        }

        Prestasi::create($data);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = Prestasi::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'nullable|string|max:100',
            'tingkat'   => 'nullable|string|max:100',
            'tanggal'   => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['nama', 'kategori', 'tingkat', 'tanggal', 'deskripsi']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('foto')) {
            \App\Helpers\UploadHelper::deleteImage($item->foto);
            $data['foto'] = \App\Helpers\UploadHelper::uploadImage($request->file('foto'), 'prestasi', 1000, 750);
        }

        $item->update($data);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Prestasi::findOrFail($id);

        \App\Helpers\UploadHelper::deleteImage($item->foto);

        $item->delete();

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus.');
    }
}
