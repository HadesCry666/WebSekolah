<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index()
    {
        $data = Fasilitas::orderBy('urutan')->get();
        return view('back.crud_fasilitas', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ikon'      => 'nullable|string|max:100',
            'urutan'    => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'ikon', 'urutan']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fasilitas', 'public');
        }

        Fasilitas::create($data);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = Fasilitas::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ikon'      => 'nullable|string|max:100',
            'urutan'    => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'ikon', 'urutan']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('foto')) {
            if ($item->foto && Storage::disk('public')->exists($item->foto)) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $request->file('foto')->store('fasilitas', 'public');
        }

        $item->update($data);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Fasilitas::findOrFail($id);

        if ($item->foto && Storage::disk('public')->exists($item->foto)) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }
}
