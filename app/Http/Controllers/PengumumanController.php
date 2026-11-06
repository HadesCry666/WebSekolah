<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    // ADMIN
    public function index()
    {
        $data = Pengumuman::latest()->get();
        return view('back.crud_pengumuman_info', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'             => 'required|string|max:255',
            'isi'               => 'required|string',
            'lampiran'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'tanggal_publikasi' => 'required|date',
            'is_active'         => 'nullable|boolean',
        ]);

        $data = $request->only(['judul', 'isi', 'tanggal_publikasi']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('pengumuman', 'public');
        }

        Pengumuman::create($data);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = Pengumuman::findOrFail($id);

        $request->validate([
            'judul'             => 'required|string|max:255',
            'isi'               => 'required|string',
            'lampiran'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'tanggal_publikasi' => 'required|date',
            'is_active'         => 'nullable|boolean',
        ]);

        $data = $request->only(['judul', 'isi', 'tanggal_publikasi']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('lampiran')) {
            if ($item->lampiran && Storage::disk('public')->exists($item->lampiran)) {
                Storage::disk('public')->delete($item->lampiran);
            }
            $data['lampiran'] = $request->file('lampiran')->store('pengumuman', 'public');
        }

        $item->update($data);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Pengumuman::findOrFail($id);

        if ($item->lampiran && Storage::disk('public')->exists($item->lampiran)) {
            Storage::disk('public')->delete($item->lampiran);
        }

        $item->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    // FRONTEND
    public function frontIndex()
    {
        $pengumuman = Pengumuman::active()->published()->latest('tanggal_publikasi')->paginate(10);
        return view('front.pengumuman', compact('pengumuman'));
    }

    public function frontDetail($id)
    {
        $item = Pengumuman::where('is_active', true)->findOrFail($id);
        return view('front.pengumuman_detail', compact('item'));
    }
}
