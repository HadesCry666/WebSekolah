<?php

namespace App\Http\Controllers;

use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSliderController extends Controller
{
    public function index()
    {
        $data = HeroSlider::orderBy('urutan')->get();
        return view('back.crud_hero_slider', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'nullable|string|max:255',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'tombol_teks' => 'nullable|string|max:100',
            'tombol_url'  => 'nullable|string|max:255',
            'badge_teks'  => 'nullable|string|max:100',
            'urutan'      => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);

        $gambar = $request->file('gambar')->store('hero_sliders', 'public');

        HeroSlider::create([
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $gambar,
            'tombol_teks' => $request->tombol_teks,
            'tombol_url'  => $request->tombol_url,
            'badge_teks'  => $request->badge_teks,
            'urutan'      => $request->urutan ?? 0,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'Slider berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = HeroSlider::findOrFail($id);

        $request->validate([
            'judul'       => 'nullable|string|max:255',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'tombol_teks' => 'nullable|string|max:100',
            'tombol_url'  => 'nullable|string|max:255',
            'badge_teks'  => 'nullable|string|max:100',
            'urutan'      => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'tombol_teks', 'tombol_url', 'badge_teks', 'urutan']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('gambar')) {
            if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
                Storage::disk('public')->delete($item->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('hero_sliders', 'public');
        }

        $item->update($data);

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = HeroSlider::findOrFail($id);

        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'Slider berhasil dihapus.');
    }
}
