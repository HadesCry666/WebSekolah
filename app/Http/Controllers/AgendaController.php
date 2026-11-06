<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    // ADMIN
    public function index()
    {
        $data = Agenda::latest()->get();
        return view('back.crud_agenda', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'lokasi'          => 'nullable|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'     => 'nullable',
            'is_active'       => 'nullable|boolean',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'lokasi', 'tanggal_mulai', 'tanggal_selesai', 'waktu_mulai']);
        $data['is_active'] = $request->boolean('is_active', true);

        Agenda::create($data);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = Agenda::findOrFail($id);

        $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'lokasi'          => 'nullable|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'     => 'nullable',
            'is_active'       => 'nullable|boolean',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'lokasi', 'tanggal_mulai', 'tanggal_selesai', 'waktu_mulai']);
        $data['is_active'] = $request->boolean('is_active', true);

        $item->update($data);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Agenda::findOrFail($id)->delete();

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }

    // FRONTEND
    public function frontIndex()
    {
        $agenda = Agenda::active()->orderBy('tanggal_mulai', 'desc')->paginate(10);
        return view('front.agenda', compact('agenda'));
    }
}
