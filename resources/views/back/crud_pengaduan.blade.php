@extends('layouts.admin.app')

@section('title', 'Halaman Pengaduan')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Pengaduan</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="section-body">
        <h2 class="section-title">Halaman ini menampilkan semua data pengaduan</h2>

        <div class="card">
            <div class="card-header">
                <h4>Daftar Pengaduan</h4>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Hp</th>
                            <th>Judul</th>
                            <th>Isi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($data as $i => $item)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->isi, 30) }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                {{-- Tombol Lihat --}}
                                <button type="button" class="btn btn-info btn-sm"
                                        data-toggle="modal"
                                        data-target="#modalLihat{{ $item->id }}">
                                    Lihat
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.pengaduan.destroy', $item->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Modal Detail --}}
                        <div class="modal fade" id="modalLihat{{ $item->id }}" tabindex="-1"
                             role="dialog" data-backdrop="false">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">

                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Detail Pengaduan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <p><strong>Nama:</strong> {{ $item->nama }}</p>
                                        <p><strong>Email:</strong> {{ $item->email ?? '-' }}</p>
                                        <p><strong>No HP:</strong> {{ $item->no_hp ?? '-' }}</p>
                                        <p><strong>Judul:</strong> {{ $item->judul }}</p>
                                        <p><strong>Isi Pengaduan:</strong><br>{{ $item->isi }}</p>
                                        <p><strong>Tanggal:</strong> {{ $item->created_at->translatedFormat('d F Y') }}</p>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada pengaduan.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>
@endsection
