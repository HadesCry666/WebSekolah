@extends('layouts.admin.app')

@section('title', 'Ekstrakurikuler')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
<section class="section">
    <div class="section-header">
        <h1>Ekstrakurikuler</h1>
    </div>

    <div class="section-body">
        <h2 class="section-title">Halaman ini menampilkan data ekstrakurikuler</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- ============== FORM TAMBAH ============== --}}
        <div class="card mb-4">
            <div class="card-header">
                <h4>Tambah Data Ekstrakurikuler</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.ekstrakulikuler.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="judul" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="summernote-simple"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>

        {{-- ============== LIST DATA ============== --}}
        <div class="card">
            <div class="card-body">
                <h5>Daftar Ekstrakurikuler</h5>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/'.$item->gambar) }}" style="height:60px;border-radius:6px;">
                                    @endif
                                </td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    {{-- EDIT --}}
                                    <button class="btn btn-primary mr-1"
                                            data-toggle="modal"
                                            data-target="#editEkstra{{ $item->id }}">
                                        <i class="far fa-edit"></i>
                                    </button>

                                    {{-- DELETE --}}
                                    <form action="{{ route('admin.ekstrakulikuler.delete', $item->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Hapus data ini?')" class="btn btn-danger">
                                            <i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data.</td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        {{-- ============== MODAL EDIT (DILUAR TABLE) ============== --}}
        @foreach ($data as $item)
            <div class="modal fade" id="editEkstra{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <form action="{{ route('admin.ekstrakulikuler.update', $item->id) }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Ekstrakurikuler</h5>
                                {{-- tombol close versi Bootstrap 4 --}}
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label>Judul</label>
                                    <input type="text" name="judul" class="form-control" value="{{ $item->judul }}">
                                </div>

                                <div class="mb-3">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi" class="summernote-simple" rows="3">{{ $item->deskripsi }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label>Gambar</label>
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/'.$item->gambar) }}" height="60" class="d-block mb-2">
                                    @endif
                                    <input type="file" name="gambar" class="form-control">
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Tutup
                                </button>
                                <button class="btn btn-primary">Update</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        @endforeach

    </div>
      <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
</section>
@endsection
