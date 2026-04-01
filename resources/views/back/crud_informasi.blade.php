@extends('layouts.admin.app')

@section('title', 'Informasi')

@section('content')
<link rel="stylesheet" href="{{ asset('css/alert.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">


<section class="section">
    <div class="section-header">
        <h1>Informasi</h1>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="section-body">
        <h2 class="section-title">CRUD Informasi (Berita & Prestasi)</h2>

        {{-- ================= FORM TAMBAH INFORMASI ================= --}}
        <div class="card">
            <div class="card-header">
                <h4>Tambah Informasi</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.informasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="berita">Berita</option>
                            <option value="prestasi">Prestasi</option>
                        </select>
                    </div>

                 <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi_berita" class="summernote-simple" required></textarea>
                </div>


                    <div class="mb-3">
                        <label class="form-label">Gambar (opsional)</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>

                    <button class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>

        {{-- ================== TABEL INFORMASI ================== --}}
        <div class="card mt-4">
            <div class="card-header">
                <h4>Daftar Informasi</h4>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th width="40">#</th>
                            <th>Judul</th>
                            <th>Kategori</hth>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->judul }}</td>

                                <td>
                                    <span class="badge bg-{{ $row->kategori == 'berita' ? 'primary' : 'success' }}">
                                        {{ ucfirst($row->kategori) }}
                                    </span>
                                </td>

                                <td>
                                    @if($row->gambar)
                                        <img src="{{ asset('storage/'.$row->gambar) }}" width="80">
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>{{ \Illuminate\Support\Str::limit($row->deskripsi_berita, 80) }}</td>

                                <td>
                                    {{-- Tombol Edit --}}
                                <button class="btn btn-warning btn-sm"
                                        data-toggle="modal"
                                        data-target="#editModal{{ $row->id }}">
                                    Edit
                                </button>



                                    {{-- Tombol Delete --}}
                                    <form action="{{ route('admin.informasi.destroy', $row->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus informasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            {{-- ===================== MODAL EDIT ===================== --}}
                         <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" role="dialog" data-backdrop="false">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Informasi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form action="{{ route('admin.informasi.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Judul</label>
                                                    <input type="text" name="judul" class="form-control"
                                                           value="{{ $row->judul }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Kategori</label>
                                                    <select name="kategori" class="form-select" required>
                                                        <option value="berita" {{ $row->kategori == 'berita' ? 'selected' : '' }}>Berita</option>
                                                        <option value="prestasi" {{ $row->kategori == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi</label>
                                                    <textarea name="deskripsi_berita" class="form-control" rows="4" required>{{ $row->deskripsi_berita }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Gambar</label><br>
                                                    @if($row->gambar)
                                                        <img src="{{ asset('storage/'.$row->gambar) }}" width="120" class="mb-2">
                                                    @endif
                                                    <input type="file" name="gambar" class="form-control">
                                                </div>
                                            </div>

                                           <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button class="btn btn-primary">Simpan Perubahan</button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada informasi yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.summernote-simple').summernote({
            height: 150,
            toolbar: false   // simple seperti di halaman Ekstrakurikuler
        });
    });
</script>

@endsection
