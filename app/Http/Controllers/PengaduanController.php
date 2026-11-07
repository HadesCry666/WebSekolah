<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    // FRONT – Form pengaduan
    public function front()
    {
        try {
            $view = view()->exists('front.pengaduan') ? view('front.pengaduan') : view('front.Pengaduan');
            return response($view->render());
        } catch (\Throwable $e) {
            return response("ERROR_DEBUG: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . "\n" . $e->getTraceAsString(), 200);
        }
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

        $validated['status'] = 'baru';
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

    // ADMIN – update status pengaduan
    public function updateStatus(Request $request, $id)
    {
        $item = Pengaduan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:baru,proses,selesai',
        ]);

        $item->update(['status' => $request->status]);

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
