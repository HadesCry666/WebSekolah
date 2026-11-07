<?php

namespace App\Http\Controllers;

use App\Models\ProgramUnggulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramUnggulanController extends Controller
{
    public function index()
    {
        $data = ProgramUnggulan::orderBy('urutan')->get();
        return view('back.crud_program_unggulan', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'ikon'      => 'nullable|string|max:100',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'urutan'    => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'ikon', 'urutan']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = \App\Helpers\UploadHelper::uploadImage($request->file('gambar'), 'program_unggulan', 1000, 750);
        }

        ProgramUnggulan::create($data);

        return redirect()->route('admin.program-unggulan.index')
            ->with('success', 'Program unggulan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = ProgramUnggulan::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'ikon'      => 'nullable|string|max:100',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'urutan'    => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'ikon', 'urutan']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('gambar')) {
            \App\Helpers\UploadHelper::deleteImage($item->gambar);
            $data['gambar'] = \App\Helpers\UploadHelper::uploadImage($request->file('gambar'), 'program_unggulan', 1000, 750);
        }

        $item->update($data);

        return redirect()->route('admin.program-unggulan.index')
            ->with('success', 'Program unggulan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = ProgramUnggulan::findOrFail($id);

        \App\Helpers\UploadHelper::deleteImage($item->gambar);

        $item->delete();

        return redirect()->route('admin.program-unggulan.index')
            ->with('success', 'Program unggulan berhasil dihapus.');
    }
}
